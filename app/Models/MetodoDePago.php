<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodoDePago extends Model
{
    use HasFactory;

    protected $table="metodos_de_pago";

    protected $fillable=[
        "descripcion"

    ];

    //INNER JOIN con la tabla Pedidos
    public function pedidos(){
        return $this->hasMany(Pedidos::class, "id_metodo_de_pago");
    }
}
