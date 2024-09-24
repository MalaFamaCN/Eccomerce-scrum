<?php

namespace Database\Seeders;

use App\Models\Marca;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarcaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Marca::create([
            'descripcion' => 'L.G.'
        ]);
        Marca::create([
            'descripcion' => 'Philips'
        ]);
        Marca::create([
            'descripcion' => 'Asus'
        ]);
        Marca::create([
            'descripcion' => 'Samsung'
        ]);
        Marca::create([
            'descripcion' => 'Dell'
        ]);
        Marca::create([
            'descripcion' => 'TCL'
        ]);

        Marca::create([
            'descripcion' => 'H.P'
        ]);
        Marca::create([
            'descripcion' => 'Lenovo'
        ]);
        Marca::create([
            'descripcion' => 'Motorola'
        ]);
        Marca::create([
            'descripcion' => 'Xiaomi'
        ]);
        Marca::create([
            'descripcion' => 'Seasonic'
        ]);
        Marca::create([
            'descripcion' => 'Redragon'
        ]);

        Marca::create([
            'descripcion' => 'Adata'
        ]);
        Marca::create([
            'descripcion' => 'Corsair'
        ]);
        Marca::create([
            'descripcion' => 'MSI'
        ]);
        Marca::create([
            'descripcion' => 'Intel'
        ]);
        Marca::create([
            'descripcion' => 'AMD'
        ]);
        Marca::create([
            'descripcion' => 'Daewoo'
        ]);

        Marca::create([
            'descripcion' => 'Noblex'
        ]);
        Marca::create([
            'descripcion' => 'Sony'
        ]);
        Marca::create([
            'descripcion' => 'Panacom'
        ]);
        Marca::create([
            'descripcion' => 'Philco'
        ]);
        Marca::create([
            'descripcion' => 'JBL'
        ]);

        Marca::create([
            'descripcion' => 'Microsoft'
        ]);
        Marca::create([
            'descripcion' => 'Sin Marca'
        ]);
        Marca::create([
            'descripcion' => 'Nintendo'
        ]);
    }
}
