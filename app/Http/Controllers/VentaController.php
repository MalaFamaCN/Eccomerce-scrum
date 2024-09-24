<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\VentasExport;

class VentaController extends Controller
{

    public function index()
    {
        // Obtener la fecha actual
        $fechaHoy = Carbon::now();
        $fechaActual = $fechaHoy->format('Y-m-d');
        $mesActual = $fechaHoy->format('Y-m');
        $pedidos = Pedido::where('pagado', true)
                     ->whereDate('created_at', $fechaHoy)
                     ->latest()
                     ->get();
        $totalCaja = $pedidos->sum('total');
        // Retornamos una vista y enviamos la variable "productos"
        return view('panel.administrador.lista_ventas.index', compact('pedidos','fechaActual', 'mesActual' ,'totalCaja'));
    }

    public function ventasDiarias(Request $fecha)
    {
    /* $fecha = "2023-11-10"; */
    // Convertir la fecha a un objeto Carbon para garantizar el formato correcto
    $fechaCarbon = Carbon::parse($fecha->fecha);
    $fechaActual = $fechaCarbon->format('Y-m-d');
    $mesActual = $fechaCarbon->format('Y-m');
    // Filtrar los pedidos por la fecha proporcionada
    $pedidos = Pedido::where('pagado', true)
                     ->whereDate('created_at', $fechaCarbon)
                     ->latest()
                     ->get();
    $totalCaja = $pedidos->sum('total');
    return view('panel.administrador.lista_ventas.index', compact('pedidos','fechaActual' , 'mesActual', 'totalCaja'));
    }

    public function ventasMensuales(Request $fecha)
    {
    /* $fecha = "2023-11-10"; */
    // Convertir la fecha a un objeto Carbon para garantizar el formato correcto
    $fechaCarbon = Carbon::parse($fecha->fecha);
    $fechaActual = $fechaCarbon->format('Y-m-d');
    $mesActual = $fechaCarbon->format('Y-m');

    // Filtrar los pedidos por la fecha proporcionada
    $pedidos = Pedido::where('created_at', 'like', "%$mesActual%")
    ->where('pagado', true)
    ->latest()
    ->get();
    $totalCaja = $pedidos->sum('total');
    return view('panel.administrador.lista_ventas.index', compact('pedidos','fechaActual' , 'mesActual', 'totalCaja'));
    }

    public function exportarExcel() {
        return Excel::download(new VentasExport, 'Historico.xlsx');
    }

}
