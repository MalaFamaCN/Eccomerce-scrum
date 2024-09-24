<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoStock extends Model
{
    use HasFactory;

    protected $table = 'historico_stock';

    // Nombres de las columnas que son rellenables
    protected $fillable = [
        'id_producto', 'id_user', 'tipo_modif', 'motivo_modif', 'cantidad_modif',
        'cantidad_anterior', 'cantidad_nueva'
    ];
    // INNER JOIN user
    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
    // INNER JOIN producto
    public function producto(){
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
