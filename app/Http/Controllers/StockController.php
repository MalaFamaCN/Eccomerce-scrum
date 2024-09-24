<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Models\Stock;
use App\Models\Proveedor;
use App\Models\Marca;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\HistoricoStock;
use Illuminate\Http\Request;
use App\Exports\HistorialStockExport;
use App\Exports\StockExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;


class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        /*/
        Obtiene el stock de todos los productos con estado activo y luego lleva
        a la vista, una lista con el stock de productos
        /*/

        $productos = Stock::latest()->get();
        //$producto se envía luego de index a otros métodos por url                            

        return view('panel.administrador.lista_stock.index', compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        /*/
        Permite abrir un formulario, obtiene las tablas relacionadas para
        mostrar más datos.
        /*/
        $producto = new Producto();

        $marcas=Marca::get();
        $proveedores=Proveedor::get();
 
        return view('panel.administrador.lista_stock.create', compact('producto','marcas','proveedores', 'request'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockRequest $request)
    {
        /*/
        Almacena en la base de datos un producto nuevo, en estado inactivo por defecto.
        Además carga una imagen por defecto mostrando que está incompleto.
        /*/
        $producto = new Producto();
        $producto->codigo_producto = $request->get('codigo_producto');
        $producto->nombre = $request->get('nombre');
        $producto->id_proveedor = $request->get('id_proveedor');
        $producto->id_marca = $request->get('id_marca');
        $producto->stock_disponible = $request->get('stock_disponible');
        
        // Valores que se cargan por defecto
        $producto->stock_disponible = $request->get('stock_disponible') ? $request->get('stock_disponible') : 0; 
        //$producto->stock_deseado = $request->get('stock_disponible') ? $request->get('stock_disponible') : 10; 
        $producto->stock_deseado = $request->get('stock_deseado') ? $request->get('stock_deseado') : 
        ($request->get('stock_disponible') && $request->get('stock_disponible') != 0 ? $request->get('stock_disponible') : 10);
        $producto->stock_minimo = $request->get('stock_minimo') ? $request->get('stock_minimo') : 1;
        $producto->url_imagen = asset('storage/producto/sin-imagen.jpg');
        $producto->activo = 0;
        $producto->id_categoria = 7; //sin categoría
        $producto->precio = 0;

        $producto->save();
        $ultimoIdInsertado = $producto->id;

        $historico = new HistoricoStock();
        $historico->id_producto = $ultimoIdInsertado;
        $historico->id_user = auth()->user()->id; // id user que da el alta
        $historico->motivo_modif = 'Alta de nuevo producto.';
        $historico->tipo_modif = 'alta'; // por defecto cuando se da alta se crea como nuevo producto el tipo de modif
        $historico->cantidad_modif = $request->get('stock_disponible'); // el stock con el que inicia
        $historico->cantidad_anterior = 0; // la cantidad anterior siempre es cero en estos casos
        $historico->cantidad_nueva = $request->get('stock_disponible'); // es igual a la ingresada
        $historico->created_at = now();
        
        $historico->save();
        

        return redirect()
        ->route('stock.index')
        ->with('alert', 'Producto "' . $producto->nombre . '" agregado exitosamente.');
    }


   

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        $proveedor = Proveedor::find($producto->proveedor->id);
        $imagenes= explode('|', $producto->url_imagen); // separa urls

        return view('panel.administrador.lista_productos.show', compact('producto','proveedor', 'imagenes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Stock $stock)
    {
        /*/
        Guarda los datos necesarios para rellenar el form,
        lleva al form para editar el stock si se confirma
        /*/
        $producto = $stock; //acto dudoso pero funcional, revisar la relación con parámetros edit(parametros lo pasa como $stock)

        $categorias = Categoria::get();
        $marcas = Marca::get();
        $proveedores = Proveedor::get();
        $imagenes = explode('|', $producto->url_imagen); // separa urls

        return view('panel.administrador.lista_stock.edit', compact('producto', 'categorias','marcas','proveedores', 'imagenes', 'request'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StockRequest $request, Stock $stock)
    {   
        /*/
        Realiza una actualización en la tabla productos del stock y realiza un insert con los datos
        de quien modifica, el tipo de modificación, motivo y demás datos. Para ello evalúa el tipo de operación
        entonces suma o resta del stock según se indicó en el form.
        /*/
        $producto = $stock; //acto dudoso pero funcional, revisar la relación con parámetros edit(parametros lo pasa como $stock)
        
        $tipo_modif = $request->get('tipo_modif');
        $modificaStock = true; // bandera para saber si no toca stock

        switch ($tipo_modif) {
            case 'ingreso':
                $nuevoStock = $producto->stock_disponible + $request->get('cantidad_modif');
                $producto->stock_disponible = $nuevoStock; // actualiza stock
                break;
            case 'egreso':
            case 'devolucion':
                $nuevoStock = $producto->stock_disponible - $request->get('cantidad_modif');
                $producto->stock_disponible = $nuevoStock; // actualiza stock
                break;
            default:
                $modificaStock = false;
                break;
        }

        if(!$modificaStock){

            //si no modifica stock entonces no se ejecuta histórico, solo se cambia stock deseado y minimo
            if ($request->get('stock_minimo') != null) {
                $producto->stock_minimo = $request->get('stock_minimo');
            }

            if ($request->get('stock_deseado') != null) {
                $producto->stock_deseado = $request->get('stock_deseado');
            }
            
            if ($request->get('stock_minimo') != null || $request->get('stock_deseado') != null) {
                $producto->update();
            }

            return redirect()
            ->route('stock.index')
            ->with('alert', 'Se modificaron los parámetros de stock de "' . $producto->nombre . ' ' . $producto->codigo_producto . '"  exitosamente.');

        } else {
            //si modifica stock entonces se trata de un ingreso u egreso

            $historico = new HistoricoStock();
            $historico->id_producto = $producto->id;
            $historico->id_user = auth()->user()->id; // id user que modifica
            $historico->tipo_modif = $request->get('tipo_modif');
            $historico->motivo_modif = $request->get('motivo_modif');
            $historico->cantidad_anterior = $request->get('stock_disponible'); // guardo la cantidad previa a la modificación
            $historico->cantidad_modif = $request->get('cantidad_modif');
            $historico->cantidad_nueva = $nuevoStock; // guarda el resultado
            $historico->created_at = now();

            //solamente envía stock min y des si el valor dentro no es null
            $producto->stock_minimo = $request->get('stock_minimo') != null ? $request->get('stock_minimo') : $producto->stock_minimo;
            $producto->stock_deseado = $request->get('stock_deseado') != null ? $request->get('stock_deseado') : $producto->stock_deseado;

            $producto->update();
            $historico->save();

            return redirect()
            ->route('stock.index')
            ->with('alert', 'Stock de producto "' . $producto->nombre . ' ' . $producto->codigo_producto . '" modificado exitosamente.');

        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stock $stock)
    {
        //
    }

    public function historicoVista()
    {   
        /*/
        Obtiene el stock de todos los productos con estado activo y luego lleva
        a la vista, una lista con el stock de productos
        /*/

        $registros = HistoricoStock::latest()->select('id','num_registro','id_producto','id_user','tipo_modif','cantidad_modif',
                            'cantidad_anterior','cantidad_nueva','motivo_modif','created_at')->get();
        //$producto se envía luego de index a otros métodos por url                            

        return view('panel.administrador.lista_stock.historico', compact('registros'));
    }

    public function showDetalle(HistoricoStock $registro)
    {
        /*/
        Lleva al mostrar el motivo de la modificación y más detalles
        /*/
        return view('panel.administrador.lista_stock.detalle', compact('registro'));
    }


    public function exportarStockExcel() {
        return Excel::download(new StockExport, 'stock.xlsx'); 
         }
    
         public function exportarStockPDF() {
            // Traemos los productos 
            $producto = Producto::latest()->get();
            // capturamos la vista y los datos que enviaremos a la misma
            $pdf = PDF::loadView('panel.administrador.lista_stock.pdf_stock', compact('producto'));
            // Renderizamos la vista
            $pdf->render();
            // Visualizaremos el PDF en el navegador
            return $pdf->stream('Stock.pdf');
            }


            public function exportarHistorialExcel() {
                return Excel::download(new HistorialStockExport, 'historial.xlsx'); 
                 }
            
                 public function exportarHistorialPDF() {
                    // Traemos los productos 
                    $productoo = HistoricoStock::select('productos.codigo_producto','productos.nombre','users.email','tipo_modif','cantidad_modif','historico_stock.created_at')
                    ->join('productos', 'productos.id', 'historico_stock.id_producto')
                    ->join('users', 'users.id', 'historico_stock.id_user')->get();
                     
                    // capturamos la vista y los datos que enviaremos a la misma
                    $pdf = PDF::loadView('panel.administrador.lista_stock.pdf_historial', compact('productoo'));
                    // Renderizamos la vista
                    $pdf->render();
                    // Visualizaremos el PDF en el navegador
                    return $pdf->stream('historial.pdf');
                    }
        

   

}
