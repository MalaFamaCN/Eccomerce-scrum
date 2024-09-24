<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Echo_;
use App\Exports\ProveedorExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;




class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $proveedores = Proveedor::latest()->get();
        // Retornamos una vista y enviamos la variable "productos"
        return view('panel.administrador.lista_proveedores.index', compact('proveedores'));
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $proveedor = new Proveedor();
        return view('panel.administrador.lista_proveedores.create', compact('proveedor'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProveedorRequest $request)
    {
        //
        $proveedor = new Proveedor();
        $proveedor->descripcion = $request->get('descripcion');
        $proveedor->cuit = $request->get('cuit');
        $proveedor->razon_social = $request->get('razon_social');
        $proveedor->direccion = $request->get('direccion');
        $proveedor->telefono = $request->get('telefono');
        $proveedor->correo = $request->get('correo');
        $proveedor->activo = $request->get('activo');


        // Almacena la info del producto en la BD
        $proveedor->save();
        return redirect()
            ->route('proveedor.index')
            ->with('alert', 'Proveedor "' . $proveedor->descripcion . '" agregado exitosamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $proveedor = Proveedor::find($id);
        return view('panel.administrador.lista_proveedores.show', compact('proveedor'));  
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $proveedor = Proveedor::find($id);
        return view('panel.administrador.lista_proveedores.edit', compact('proveedor'));
    }


    public function exportarProveedorExcel() {
        return Excel::download(new ProveedorExport, 'proveedores.xlsx'); 
         }

         public function exportarProveedorPDF() {
            // Traemos los productos 
            $proveedor = Proveedor::latest()->get();
            // capturamos la vista y los datos que enviaremos a la misma
            $pdf = PDF::loadView('panel.administrador.lista_proveedores.pdf_proveedor', compact('proveedor'));
            // Renderizamos la vista
            $pdf->render();
            // Visualizaremos el PDF en el navegador
            return $pdf->stream('proveedor.pdf');
            }


    public function update(ProveedorRequest $request, $id)
    {
        //

        $proveedor = Proveedor::find($id);

        $proveedor->descripcion = $request->get('descripcion');
        $proveedor->cuit = $request->get('cuit');
        $proveedor->razon_social = $request->get('razon_social');
        $proveedor->direccion = $request->get('direccion');
        $proveedor->telefono = $request->get('telefono');
        $proveedor->correo = $request->get('correo');
        $proveedor->activo = $request->get('activo');


        //Actualiza la info del producto en la BD
        $proveedor->update();

        return redirect()
            ->route('proveedor.index')
            ->with('alert', 'Proveedor "' . $proveedor->descripcion . '" actualizado exitosamente.');
    }

    /**
     * ACTIVA O DESACTIVA UNA CATEGORIA
     */
    public function cambiarEstado(Request $request)
    {
        $proveedor = Proveedor::find($request->_id);

        if (!$proveedor) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        $proveedor->activo = !$proveedor->activo; // Cambia el estado
        $proveedor->save();

        return response()->json(['message' => 'Estado de categoría cambiado con éxito']);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

 
}
