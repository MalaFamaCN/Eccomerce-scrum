<?php

namespace App\Exports;

use App\Models\Producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductosExport implements FromCollection, WithHeadings
{
public function headings(): array
{
return [
'#','nombre','categoria','Marca','Precio', 'Stock'
];
}
public function collection()
{
    return Producto::select('codigo_producto','nombre', 'categorias.descripcion as categoria','marcas.descripcion as marca' ,'precio','stock_disponible')
    ->join('categorias', 'categorias.id', 'productos.id_categoria')
    ->join('marcas', 'marcas.id', 'productos.id_marca')
    ->get();
}
}

