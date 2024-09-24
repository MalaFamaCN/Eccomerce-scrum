<?php

namespace App\Exports;

use App\Models\HistoricoStock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HistorialStockExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Codigo','Nombre', 'usuario', 'Tipo Modificacion', 'Cantidad','Fecha' 
        ];
    }
    public function collection()
    {
        return HistoricoStock::select('productos.codigo_producto','productos.nombre','users.email','tipo_modif','cantidad_modif','historico_stock.created_at')
       ->join('productos', 'productos.id', 'historico_stock.id_producto')
       ->join('users', 'users.id', 'historico_stock.id_user')
          

            ->get();
    }
}
