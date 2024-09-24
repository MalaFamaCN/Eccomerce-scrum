<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Models\Marca;
use App\Models\Producto;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockExport;
use Barryvdh\DomPDF\Facade\PDF;
use App\Models\HistoricoStock;
use App\Exports\ProductosExport;


class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $productos = Producto::where('vendedor_id', auth()->user()->id) // Filtra los productos del VENDEDOR LOGUEADO
        // ->latest() // Ordena de manera DESC por el campo "created_at"
        // ->get(); // Convierte los datos extraidos de la BD en un Array 
        $productos = Producto::latest()->get();
        // Retornamos una vista y enviamos la variable "productos"
        return view('panel.administrador.lista_productos.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        //Creamos un Producto nuevo para cargarle datos
        $producto = new Producto();

        //Recuperamos todas las categorias de la BD
        $categorias = Categoria::get(); //Recordar importar el modelo Categoria
        $marcas = Marca::get(); //Recordar importar el modelo Categoria
        $proveedores = Proveedor::get();

        $imagenes = explode('|', $producto->url_imagen);

        //Retornamos la vista de creacion de productos, enviamos al producto y las categorias
        return view('panel.administrador.lista_productos.create', compact('producto', 'categorias', 'marcas', 'proveedores', 'imagenes')); //compact(mismo nombre de la variable)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductoRequest $request)
    {
        //
        //dd($request->all());

        $producto = new Producto();
        $producto->codigo_producto = $request->get('codigo_producto');
        $producto->nombre = $request->get('nombre');
        $producto->descripcion = $request->get('descripcion');
        $producto->precio = $request->get('precio');
        $producto->id_categoria = $request->get('id_categoria');
        $producto->id_proveedor = $request->get('id_proveedor');
        $producto->id_marca = $request->get('id_marca');
        /*/ Valores por defecto:
        si no ingresa nada o porque no tiene permiso en stock, entonces se asignan valores por defecto
        stock deseado es = a stock disponible si no se indica cuánto es el stock deseado
        stock minimo = 1 si no se indica cuánto
        /*/
        $producto->stock_disponible = $request->get('stock_disponible') ? $request->get('stock_disponible') : 0;
        $producto->stock_deseado = $request->get('stock_disponible') ? $request->get('stock_disponible') : 10;
        $producto->stock_minimo = $request->get('stock_minimo') ? $request->get('stock_minimo') : 1;
        $producto->activo = 0;

        if ($files = $request->file('url_imagen')) {

            $url_imagen = [];

            foreach ($files as $file) {
                //$imagen_name = md5(rand(100, 10000)); //cifrado del nombre
                //$extension = strtolower($file->getClientOriginalExtension()); //obtengo extension
                //$imagen_full_name = $imagen_name . '.' . $extension; //armado del nombre completo del file
                $url_imagen[] = asset($file->store('public/producto')); //guardo en un array las direcciones de cada uno 
                //dd($url_imagen); //puedo ver que se envía la url completa
                $imagenes = implode('|', $url_imagen); //contiene todas las url de las imagenes del array unidos con |
            }
        }

        $producto->url_imagen = asset(str_replace('public', 'storage', $imagenes)); // Almacena la info del producto en la BD la url de tas las imagenes

        $producto->save();

        // Registro para el histórico
        $ultimoIdInsertado = $producto->id;

        $historico = new HistoricoStock();
        $historico->id_producto = $ultimoIdInsertado;
        $historico->id_user = auth()->user()->id; // id user que da el alta
        $historico->motivo_modif = 'Alta de nuevo producto.';
        $historico->tipo_modif = 'alta'; // por defecto cuando se da alta se crea como nuevo producto el tipo de modif
        $historico->cantidad_modif = $producto->stock_disponible;
        $historico->cantidad_anterior = 0; // la cantidad anterior siempre es cero en alta producto
        $historico->cantidad_nueva = $producto->stock_disponible; // es igual a la ingresada
        $historico->created_at = now();

        $historico->save();

        return redirect()
            ->route('producto.index')
            ->with('alert', 'Producto "' . $producto->nombre . '" agregado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $proveedor = Proveedor::find($producto->proveedor->id);
        $imagenes = explode('|', $producto->url_imagen); // separa urls

        return view('panel.administrador.lista_productos.show', compact('producto', 'proveedor', 'imagenes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
        $categorias = Categoria::get();
        $marcas = Marca::get();
        $proveedores = Proveedor::get();

        $imagenes = explode('|', $producto->url_imagen); // separa urls

        return view('panel.administrador.lista_productos.edit', compact('producto', 'categorias', 'marcas', 'proveedores', 'imagenes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductoRequest $request, Producto $producto)
    {
        // BORRA EL STOCK DEL PRODUCTO REVISAR
        $producto->codigo_producto = $request->get('codigo_producto');
        $producto->nombre = $request->get('nombre');
        $producto->activo = $request->get('activo');
        $producto->precio = $request->get('precio');
        $producto->descripcion = $request->get('descripcion');
        $producto->id_proveedor = $request->get('id_proveedor');
        $producto->id_categoria = $request->get('id_categoria');
        $producto->id_marca = $request->get('id_marca');
        $existeImagen = $request->hasFile('url_imagen'); //bandera para validar así no cambie la imagen existente si no se sube nada
        //dd($existeImagen);
        if ($existeImagen) {
            // si existe imagen cargadaa en el input (por defecto no tiene nada), significa que hay que mandarla a la bd reemplazando las urls existentes

            $files = $request->file('url_imagen'); //obtiene files
            $url_imagen = [];

            foreach ($files as $file) {

                $url_imagen[] = asset($file->store('public/producto')); //guardo en un array las direcciones de cada uno     
                $imagenes = implode('|', $url_imagen); //contiene todas las url de las imagenes del array unidos con |

            }

            $url_imagen = $producto->url_imagen = asset(str_replace('public', 'storage', $imagenes)); // Almacena la info del producto en la BD la url de tas las imagenes
            //dd($url_imagen);
            $producto->url_imagen = $url_imagen;

            //dd($producto);

        }

        // Actualiza la info del producto en la BD
        $producto->update();

        return redirect()
            ->route('producto.index')
            ->with('alert', 'Producto "' . $producto->nombre . '" actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $id)
    {
    }

    public function cambiarEstado(Request $request)
    {
        $producto = Producto::find($request->_id);

        if (!$producto) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        $producto->activo = !$producto->activo; // Cambia el estado
        $producto->save();

        return response()->json(['message' => 'Estado de categoría cambiado con éxito']);
    }

    public function restarStock($idProducto, $cant_restar)
    {
        $producto = Producto::find($idProducto);

        $stockAnterior = $producto->stock_disponible; // Guardo el stock anterior a la merma
        $producto->stock_disponible -= $cant_restar; // Merma el stock

        // Registro para el histórico
        $historico = new HistoricoStock();
        $historico->id_producto = $idProducto;
        $historico->id_user = auth()->user()->id; // id user que realiza la compra
        $historico->motivo_modif = 'Venta de producto en tienda.';
        $historico->tipo_modif = 'venta'; // por defecto cuando se da alta se crea como nuevo producto el tipo de modif
        $historico->cantidad_modif = $cant_restar;
        $historico->cantidad_anterior = $stockAnterior;
        $historico->cantidad_nueva = $producto->stock_disponible; // ya está mermado el stock
        $historico->created_at = now();
        $historico->save();

        $producto->save();
    }

    public function sumarStock($idProducto, $cant_aumentar)
    {
        $producto = Producto::find($idProducto);

        $stockAnterior = $producto->stock_disponible; // Guardo el stock anterior a la suma
        $producto->stock_disponible += $cant_aumentar; // Aumenta el stock


        // Registro para el histórico
        $historico = new HistoricoStock();
        $historico->id_producto = $idProducto;
        $historico->id_user = auth()->user()->id; // id user que realiza la compra
        $historico->motivo_modif = 'Devolución de producto por cancelación de pedido o por devolución de producto de compra.';
        $historico->tipo_modif = 'cancelación'; 
        $historico->cantidad_modif = $cant_aumentar;
        $historico->cantidad_anterior = $stockAnterior;
        $historico->cantidad_nueva = $producto->stock_disponible; // ya está aumentado el stock
        $historico->created_at = now();
        $historico->save();

        $producto->save();
    }

    public function exportarProductosExcel()
    {
        return Excel::download(new ProductosExport, 'productos.xlsx');
    }

    public function exportarProductosPDF()
    {
        // Traemos los productos 
        $productos = Producto::latest()->get();
        // capturamos la vista y los datos que enviaremos a la misma
        $pdf = PDF::loadView('panel.administrador.lista_productos.pdf_productos', compact('productos'));
        // Renderizamos la vista
        $pdf->render();
        // Visualizaremos el PDF en el navegador
        return $pdf->stream('productos.pdf');
    }

    public function graficosProductosxCategoria()
    {
        // Si se hace una peticion AJAX
        if (request()->ajax()) {
            $labels = [];
            $counts = [];
            $totalPedidos = [];
            $totalPedidosAlmacen = [];
            $estados = ['Pagado', 'Cancelado', 'Esperando Pago'];
            $estadosAlmacen = ['Enviados', 'En Preparacion', 'Pendientes'];

            // Cantidad de Stock de cada Categoria
            $categorias = Categoria::where('activo', 1)->get();
            foreach ($categorias as $categoria) {
                $labels[] = $categoria->descripcion;
                $counts[] = Producto::where('id_categoria', $categoria->id)->count();
            }

            // Total de Pedidos Pagados/Cancelados/Esperando Pago
            $totalPedidosPagados= Pedido::where('pagado', 1)->count();
            $totalPedidosCancelados = Pedido::where('cancelado', 1)->count();
            $totalPedidosEsperandoPago = Pedido::where('pagado', 0)->count();
            $totalPedidos[] = $totalPedidosPagados;
            $totalPedidos[] = $totalPedidosCancelados;
            $totalPedidos[] = $totalPedidosEsperandoPago;

            // Total de Pedidos Enviados/En Preparacion
            $totalPedidosAlmacenEnviados = Pedido::where('enviado', 1)->count();
            $totalPedidosAlmacenEnPreparacion = Pedido::where('en_preparacion', 1)->count();
            $totalPedidosAlmacenPendientes = Pedido::where('en_preparacion', 0)->where('enviado', 0)->where('cancelado', 0)->count();
            $totalPedidosAlmacen [] = $totalPedidosAlmacenEnviados;
            $totalPedidosAlmacen [] = $totalPedidosAlmacenEnPreparacion;
            $totalPedidosAlmacen [] = $totalPedidosAlmacenPendientes;


            $response = [
                'success' => true,
                'data' => [$labels, $counts, $totalPedidos, $estados, $estadosAlmacen, $totalPedidosAlmacen]
            ];
            return json_encode($response);
        }
        return view('home');
    }

    public function exportarGraficosPDF(Request $request)
    {
        // Traemos los datos enviados desde el formulario
        $data = $request->get('config_grafics');
        // capturamos la vista y los datos que enviaremos a la misma
        $pdf = PDF::loadView('pdfs.graficos.pdf_productos_graficos', compact('data'));
        // Renderizamos la vista
        $pdf->render();
        // Visualizaremos el PDF en el navegador
        return $pdf->stream('chartjs_productos.pdf');
    }
}
