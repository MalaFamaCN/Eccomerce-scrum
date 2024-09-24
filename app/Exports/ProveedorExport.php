<?php

namespace App\Exports;

use App\Models\Proveedor;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProveedorExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'Nombre', 'Cuit', 'Razon Social', 'Direccion', 'Telefono', 'Email'
        ];
    }
    public function collection()
    {
        return Proveedor::select('descripcion', 'cuit', 'razon_social', 'direccion', 'telefono', 'correo')
            ->get();
    }
}
