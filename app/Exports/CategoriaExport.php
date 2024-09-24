<?php

namespace App\Exports;

use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoriaExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
          'Nombre'
        ];
    }
    public function collection()
    {
        return Categoria::select('descripcion')
            ->get();
    }
}
