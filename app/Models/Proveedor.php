<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    // Nombre de la tabla que se conecta a este Modelo
    protected $table = 'proveedores';
    // Nombres de las columnas que son modificables
    protected $fillable = [ 
        'descripcion', 'cuit', 'razon_social', 'direccion', 'telefono', 'correo', 'activo'
    ];

    // INNER JOIN con la tabla Productos
    // por medio de la FK id_categoria
    public function productos()
    {
        return $this->hasMany(Producto::class, 'id_proveedor');
    }
}
