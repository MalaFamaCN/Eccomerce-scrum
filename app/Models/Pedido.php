<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    use HasFactory;

    // Nombre de la tabla que se conecta a este Modelo
    protected $table = 'pedidos';

    // Nombres de las columnas que son modificables
    protected $fillable = [
    'pagado','en_preparacion', 'cancelado' ,'enviado' , 'id_pedido' , 'num_seguimiento'
    ];
    
    // INNER JOIN 
    public function productos() {
    return $this->belongsTo(MetodoDePago::class, 'id_metodo_de_pago');
    // INNER JOIN 
    }
    // INNER JOIN 
    public function user() {
    return $this->belongsTo(User::class, 'id_cliente');
    }
}
