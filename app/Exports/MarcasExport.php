<?php

namespace App\Exports;

use App\Models\Marca;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MarcasExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
          'Descripcion'
        ];
    }
    public function collection()
    {
        return Marca::select('descripcion')
            ->get();
    }
}
