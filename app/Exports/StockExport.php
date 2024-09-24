<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Codigo', 'Nombre', 'Marca', 'Stock'
        ];
    }
    public function collection()
    {
        return Producto::select('codigo_producto', 'nombre','marcas.descripcion','stock_disponible')
        ->join('marcas', 'marcas.id', 'productos.id_marca')
        ->get();
    }
}
