<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class metodos_de_pago extends Model
{
    use HasFactory;

    protected $table="metodos_de_pago";

    protected $fillable=[
        "descripcion"

    ];

    //INNER JOIN con la tabla Pedidos
    public function productos(){
        return $this->hasMany(Pedidos::class, "id_metodo_de_pago");
    }
}
