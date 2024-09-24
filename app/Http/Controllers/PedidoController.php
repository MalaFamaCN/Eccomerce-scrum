<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProductoController;
use App\Http\Requests\PedidoRequest;
use App\Jobs\EmailConfirmandoPedidoJob;
use App\Jobs\EnviarFacturaJob;
use App\Mail\EnviarFacturaMailable;
use App\Mail\PedidoMailable;
use App\Models\Categoria;
use App\Models\User;
use App\Models\Pedido;
use App\Models\DetallePedidos;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MercadoPagoService;
use Barryvdh\DomPDF\Facade\PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class PedidoController extends Controller
{
    public function __construct( //Incluye el servicio de MercadoPago
        private MercadoPagoService $mercadoPagoService
    ) {
    }

    public function index() //Trae los pedidos a mostrar en el panel
    {
        $id_cliente = Auth::id();
        $pedidos = Pedido::where('id_cliente', $id_cliente)->get();
        // Retornamos una vista y enviamos las variables
        return view('panel.cliente.lista_usuarios.misCompras', compact('pedidos'));
    }

    public function create() //Crea un pedido con los items que tiene en el carrito el cliente
    {
        $pedido = new Pedido();
        $user_id = Auth::id();
        $cliente = User::find($user_id);
        $carrito = DetallePedidos::latest()->where('id_cliente', $user_id)->whereNull('id_pedido')->with('productos')->get();

        $pedido->nombre = $cliente->name;
        $pedido->apellido = $cliente->apellido;
        $pedido->dni = $cliente->dni;
        $pedido->correo = $cliente->email;
        $pedido->telefono = $cliente->telefono;
        $pedido->direccion = $cliente->direccion;

        $categorias = Categoria::where('activo', 1)->get();

        return view('frontend.pages.checkout', compact('pedido', 'carrito', 'categorias'));
    }


    public function store(PedidoRequest $request) //Guarda el pedido si se puede
    {
        $pedido = new Pedido();

        $pedido->id_cliente = Auth::id();
        $pedido->nombre = $request->get('nombre');
        $pedido->apellido = $request->get('apellido');
        $pedido->dni = $request->get('dni');
        $pedido->telefono = $request->get('telefono');
        $pedido->direccion = $request->get('direccion');
        $pedido->correo = $request->get('email');
        $pedido->codigo_postal = $request->get('codigo_postal');

        $ultimoNumPedido = Pedido::max('num_pedido');
        $nuevoNumPedido = $ultimoNumPedido ? $ultimoNumPedido + 1 : 100; // Trae el último número de pedido de la DB y lo aumenta en 1
        $pedido->num_pedido = $nuevoNumPedido;

        //Consulta el carrito del cliente y suma el total
        $carrito = DetallePedidos::latest()->where('id_cliente', Auth::id())->whereNull('id_pedido')->with('productos')->get();
        foreach ($carrito as $item) {
            $pedido->total += $item->subtotal * $item->cant_producto;
        }
        //Si el carrito esta vacion, entonces no se genera el pedido
        if (!$pedido->total) {
            return redirect()
                ->route('MandarDatosPaginaInicio')
                ->with('alert', 'No se puede guardar un pedido vacio. ' . '¡Agrega algunos productos al carrito por favor!');
        }
        //Guarda por primera vez el pedido, pero sin link de pago
        $pedido->save();
        //Le agrego este ID de pedido a los items que estaban en el carrito: 
        DetallePedidos::whereNull('id_pedido')->where('id_cliente', $pedido->id_cliente)->update(['id_pedido' => $pedido->id]);
        $preferencia = $this->mercadoPagoService->crearPreferencia($carrito, $pedido->id); //Creo link de pago

        //Bajo del stock los productos que se vendieron
        $productoController = app(ProductoController::class);

        foreach ($carrito as $item) {
            $idProducto = $item->id_producto;
            $cant_vendida = $item->cant_producto;
            $productoController->restarStock($idProducto, $cant_vendida);
        }

        //Guardo link de pago en la db
        $pedido->linkDePago = $preferencia->init_point;
        $pedido->save();


        EmailConfirmandoPedidoJob::dispatch($pedido->id)->onConnection('database'); //Envio confirmacion por mail mediante cola de trabajo 
        //$this->avisoPedidoConfirmado($pedido->id); //Envio confirmacion de pedido al mail

        return redirect()
            ->route('MandarDatosPaginaInicio')
            ->with('alert', 'Pedido de "' . $pedido->nombre . " " . $pedido->apellido . '" agregado exitosamente. Con N°' . $pedido->num_pedido . '. Abriendo link de pago...')
            ->with('redirectUrl', $preferencia->init_point);
    }


    public function itemsPedido($id) //Consulta los items de un pedido
    {
        $detallesPedido = DetallePedidos::latest()->where('id_pedido', $id)->with('productos')->get();
        return response()->json($detallesPedido);
    }

    public function pago(Request $request) //Registra el pago de un pedido
    {
        //Funcion para consultar si un pedido ya fue pagado
        $payment_id = $request->payment_id; //Id del pago, se ve en el comprobante
        $token = config('mercadopago.access_token');
        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=$token");
        $response = json_decode($response);
        $pedido_id = $request->external_reference; //Trae el ID del pedido, que mandamos por external_reference al crear la preferencia de mercado pago
        $pedido = Pedido::find($pedido_id); //busco el pedido

        //Si no se realiza el pago y se vuelve al sitio
        if (!isset($response->error)) {
            $status = $response->status;
        } else {

            return redirect()
                ->route('pedidos.index')
                ->with('error', 'Pedido N°' . $pedido->num_pedido . ' pago cancelado. Vuelve a intentarlo en este panel.');
        }

        //Si se vuelve al sitio luego de pagar el pedido con mercado pago
        if ($status == "approved") {
            $pedido->pagado = true; //Cambia estado del pedido
            $urlPDF = $this->generarFacturaPDF($pedido->id); //Genera factura 
            $pedido->urlFactura = $urlPDF;
            $pedido->save(); //Guarda el pedido exitosamente

            //$this->avisoPagoConfirmado($pedido->id); //Envio factura por mail
            EnviarFacturaJob::dispatch($pedido->id)->onConnection('database'); //Envio factura por mail mediante cola de trabajo 

            return redirect()
                ->route('pedidos.index')
                ->with('alert', 'Pedido N°' . $pedido->num_pedido . ' pagado exitosamente. Con N° de operación: ' . $response->id);
        } else {
            //Si no se pudo pagar, no cambia el estado del pedido a pagado
            return redirect()
                ->route('pedidos.index')
                ->with('error', 'Pedido N°' . $pedido->num_pedido . ' no se pudo completar el pago. Con N° operación: ' . $response->id);
        }
    }

    public function cancelarPedido($pedido_id) //Cancela un pedido
    {
        //Cancelo el pedido
        $pedido = Pedido::find($pedido_id);
        $pedido->cancelado = true;

        //Traigo el carrito creado con este id de pedido
        $carrito = DetallePedidos::latest()->where('id_pedido', $pedido_id)->with('productos')->get();

        //Accedo a la funcion SumarStock para devolver los items reservados en el pedido
        $productoController = app(ProductoController::class);
        foreach ($carrito as $item) {
            $idProducto = $item->id_producto;
            $cant_vendida = $item->cant_producto;
            $productoController->sumarStock($idProducto, $cant_vendida);
        }

        $pedido->save();
    }

    public function generarFacturaPDF($id)
    { //Genero la factura una vez se pague el pedido
        $pedido = Pedido::find($id);
        $fechaActual = Carbon::now();
        /* $carrito = DetallePedidos::latest()->where('id_pedido', $id)->with('productos')->get();
        return view('pdfs.factura.factura', compact('pedido', 'carrito', 'fechaActual')); */

        $carrito = DetallePedidos::latest()->where('id_pedido', $id)->with('productos')->get();
        $pdf = PDF::loadView('pdfs.factura.factura', compact('pedido', 'carrito', 'fechaActual'));

        // Guardar el PDF en una carpeta dentro de storage/app/public
        $pdfPath = storage_path('app/public/pdfs/facturas/');
        $pdfFileName = 'factura_' . $pedido->num_pedido . '.pdf';
        $pdf->save($pdfPath . $pdfFileName);

        // Retornar la ruta del PDF guardado
        return '/storage/pdfs/facturas/' . $pdfFileName; //Regresa la URL PUBLICA de la factura

    }

    /*     public function avisoPedidoConfirmado($id){ //Envio mail una vez se genere el pedido
        $pedido = Pedido::find($id);
        $data = [
            'name' => $pedido->nombre . " " . $pedido->apellido,
            'email' => $pedido->correo, // Correo del Destinatario
            'num_pedido' => $pedido->num_pedido,
            'fecha' => $pedido->created_at
            ];
            // Envio de mail
            Mail::to($data['email'])->send(new PedidoMailable($data));
    } */

    /* public function avisoPagoConfirmado($id){ //Envio mail una vez se genere el pedido
        $pedido = Pedido::find($id);
        $data = [
            'name' => $pedido->nombre . " " . $pedido->apellido,
            'email' => $pedido->correo, // Correo del Destinatario
            'num_pedido' => $pedido->num_pedido,
            'fecha' => $pedido->created_at,
            'fecha_pago' => $pedido->updated_at,
            'urlFactura' => public_path('storage/pdfs/facturas/factura_' . $pedido->num_pedido . '.pdf')
            ];
            // Envio de mail
            Mail::to($data['email'])->send(new EnviarFacturaMailable($data)); 
    } 
 */
    public function pedidosPagados()
    {
        $pedidos = Pedido::where('pagado', 1)
        ->where('enviado', '0')
        ->orderBy('updated_at', 'asc')
        ->get();

        return view('panel.almacen.lista_pedidos.index', compact('pedidos'));
    }

    public function prepararPedido($id)
    {
        $pedido = Pedido::findOrFail($id);
        $pedido->en_preparacion = true;
        $pedido->save();

        return redirect()->back();
    }

    public function guardarNumero(Request $request, $id)
    {
        $numero = $request->input('numero');

        $pedido = Pedido::find($id);
        $pedido->num_seguimiento = $numero;
        $pedido->enviado = true;
        $pedido->en_preparacion = false;
        $pedido->save();

        return redirect()->back();
    }

    public function pedidosEnviados()
    {
        $pedidos = Pedido::where('pagado', 1)
        ->where('enviado', 1)
        ->whereNotNull('num_seguimiento') 
        ->orderBy('updated_at', 'asc')
        ->get();

        return view('panel.almacen.lista_pedidos.pedidosEnviados', compact('pedidos'));
    }
}
