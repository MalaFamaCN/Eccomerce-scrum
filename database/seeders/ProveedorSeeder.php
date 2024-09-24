<?php

namespace Database\Seeders;

use App\Models\Proveedor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Proveedor::create([
            'descripcion' => 'Tech Data',
            'cuit' => '12345678',
            'razon_social' => 'Leyton Cristian',
            'direccion' => 'Vicente Lopez 2887',
            'telefono' => '3875459077',
            'correo' => 'cdl@esmarty.com',
        ]);
        Proveedor::create([
            'descripcion' => 'Ingram Micro',
            'cuit' => '39784560',
            'razon_social' => 'Goku Black',
            'direccion' => 'Planeta Kaio 878',
            'telefono' => '3875658732',
            'correo' => 'black@esmarty.com',
        ]);
        Proveedor::create([
            'descripcion' => 'Synnex',
            'cuit' => '39602131',
            'razon_social' => 'Mebac Salta',
            'direccion' => 'Mendoza 213',
            'telefono' => '3875654332',
            'correo' => 'mebac@esmarty.com',
        ]);
        Proveedor::create([
            'descripcion' => 'MediaMarkt',
            'cuit' => '25098560',
            'razon_social' => 'Liliana Galdeano',
            'direccion' => 'Av. Virrey Toledo 1026',
            'telefono' => '3875459067',
            'correo' => 'galdeano@esmarty.com',
        ]);
        Proveedor::create([
            'descripcion' => 'Arrow Electronics',
            'cuit' => '20397805206',
            'razon_social' => 'Shenlong Salta',
            'direccion' => 'Av. Siempre Viva 123',
            'telefono' => '3876907345',
            'correo' => 'redragon@esmarty.com',
        ]);

        Proveedor::create([
            'descripcion' => 'Avnet',
            'cuit' => '203978052016',
            'razon_social' => 'Shenlong Salta 2',
            'direccion' => 'Av. Siempre Viva 1243',
            'telefono' => '38769073145',
            'correo' => 'redragon2@esmarty.com',
        ]);
    }
}
