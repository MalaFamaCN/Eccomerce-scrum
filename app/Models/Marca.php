<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    // Nombre de la tabla que se conecta a este Modelo
    protected $table = 'marcas';
    // Nombres de las columnas que son modificables
    protected $fillable = [
    'descripcion', 'activo'
    ];
    
    // INNER JOIN con la tabla Productos
    // por medio de la FK id_marca
    public function productos() {
    return $this->hasMany(Producto::class, 'id_marca'); 
    }
}
