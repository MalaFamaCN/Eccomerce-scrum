<?php

namespace Database\Seeders;
use App\Models\metodos_de_pago;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MetodosDePagoSeeder extends Seeder
{
    
    public function run(): void
    {
        metodos_de_pago::create([
            "descripcion" => "Debito"
        ]);
        metodos_de_pago::create([
            "descripcion" => "Credito"
        ]);
        metodos_de_pago::create([
            "descripcion" => "Transferencia"
        ]);
    }
}
