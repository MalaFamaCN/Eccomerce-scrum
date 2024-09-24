<?php

namespace App\Http\Controllers;

use App\Exports\CategoriaExport;
use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;
use App\Exports\CategoriaExportExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;


class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categorias = Categoria::latest()->get();
        // Retornamos una vista y enviamos la variable "categorias"
        return view('panel.administrador.lista_categorias.index', compact('categorias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categoria = new Categoria();
        return view('panel.administrador.lista_categorias.create', compact('categoria')); //compact(mismo nombre de la variable)

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaRequest $request)
    {
        //
        $categoria = new Categoria();
        $categoria->descripcion = $request->get('descripcion');
        $categoria->activo = $request->get('activo');

        // Almacena la info del producto en la BD
        $categoria->save();
        return redirect()
            ->route('categoria.index')
            ->with('alert', 'Categoria "' . $categoria->descripcion . '" agregada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
        return view('panel.administrador.lista_categorias.show', compact('categoria')); 
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
        // 
        return view('panel.administrador.lista_categorias.edit', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        //
        $categoria->descripcion = $request->get('descripcion');
        $categoria->activo = $request->get('activo');

        // Actualiza la info del producto en la BD
        $categoria->update();

        return redirect()
            ->route('categoria.index')
            ->with('alert', 'Categoria "' . $categoria->descripcion . '" actualizada exitosamente.');
    }

    /**
     * ACTIVA O DESACTIVA UNA CATEGORIA
     */
    public function cambiarEstado(Request $request)
    {
        $categoria = Categoria::find($request->_id);

        if (!$categoria) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        $categoria->activo = !$categoria->activo; // Cambia el estado
        $categoria->save();

        return response()->json(['message' => 'Estado de categoría cambiado con éxito']);
    }
    // public function MandarDatosCategoriasPagina()
    // {
    //     $categorias = Categoria::latest()->get();
    //     // Retornamos una vista y enviamos la variable "categorias"
    //     return view('frontend.index', compact('categorias'));
    // }


    public function exportarCategoriaExcel() {
        return Excel::download(new CategoriaExport, 'categorias.xlsx'); 
         }

         public function exportarCategoriaPDF() {
            // Traemos los productos 
            $categorias = Categoria::latest()->get();
            // capturamos la vista y los datos que enviaremos a la misma
            $pdf = PDF::loadView('panel.administrador.lista_categorias.pdf_categoria', compact('categorias'));
            // Renderizamos la vista
            $pdf->render();
            // Visualizaremos el PDF en el navegador
            return $pdf->stream('categorias.pdf');
            }

}
