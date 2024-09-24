<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Models\Marca;
use Illuminate\Http\Request;
use App\Exports\MarcasExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\PDF;


class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $marcas = Marca::latest()->get();
        // Retornamos una vista y enviamos la variable "productos"
        return view('panel.administrador.lista_marcas.index', compact('marcas'));
      
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $marca = new Marca();
        return view('panel.administrador.lista_marcas.create', compact('marca')); //compact(mismo nombre de la variable)
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MarcaRequest $request)
    {
        //
        $marca = new Marca();
        $marca->descripcion = $request->get('descripcion');
        $marca->activo = $request->get('activo');


            // Almacena la info del producto en la BD
        $marca->save();
        return redirect()
        ->route('marca.index')
        ->with('alert', 'Marca "' . $marca->descripcion . '" agregada exitosamente.');
      
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca)
    {
        //
        return view('panel.administrador.lista_marcas.show', compact('marca'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
        
        // $marcas = Marca::get();
        return view('panel.administrador.lista_marcas.edit', compact('marca'));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MarcaRequest $request, Marca $marca)
    {
        //
        $marca->descripcion = $request->get('descripcion');
        $marca->activo = $request->get('activo');
        if ($request->hasFile('url_imagen')) {
            // Subida de la imagen nueva al servidor
            $url_imagen = $request->file('url_imagen')->store('public/marca');
            $marca->url_imagen = asset(str_replace('public', 'storage', $url_imagen));
        }
        // Actualiza la info del producto en la BD
        $marca->update();
        
        return redirect()
            ->route('marca.index')
            ->with('alert', 'Marca "' .$marca->descripcion. '" actualizada exitosamente.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $marca)
    {
        //
        
    }

    public function cambiarEstado(Request $request)
    {
        $marca = Marca::find($request->_id);

        if (!$marca) {
            return response()->json(['error' => 'Categoría no encontrada'], 404);
        }

        $marca->activo = !$marca->activo; // Cambia el estado
        $marca->save();

        return response()->json(['message' => 'Estado de categoría cambiado con éxito']);
    }

    public function exportarMarcaExcel() {
        return Excel::download(new MarcasExport, 'marcas.xlsx'); 
         }

         public function exportarMarcaPDF() {
            // Traemos los productos 
            $marcas = Marca::latest()->get();
            // capturamos la vista y los datos que enviaremos a la misma
            $pdf = PDF::loadView('panel.administrador.lista_marcas.pdf_marca', compact('marcas'));
            // Renderizamos la vista
            $pdf->render();
            // Visualizaremos el PDF en el navegador
            return $pdf->stream('marcas.pdf');
            }





}