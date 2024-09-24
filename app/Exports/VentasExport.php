<?php

namespace App\Exports;

use App\Http\Controllers\PedidoController;
use App\Models\Pedido;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class VentasExport implements FromCollection, WithHeadings
{

    public function headings(): array
    {
        return [
            'N° Pedido', 'Total Pedido', 'Fecha'
        ];
    }
    public function collection()
    {

        $exportar = Pedido::select('num_pedido', 'created_at', 'total')
            ->where('pagado', true)
            ->get();

        foreach ($exportar as $pedido) {
            $pedido->fecha = Carbon::parse($pedido->created_at)->format('Y-m-d');
            unset($pedido->created_at);
        }
        return $exportar;
    }
}
