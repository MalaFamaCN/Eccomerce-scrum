<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

        // Stock va a usar la tabla de productos ya que se almacena la cantidad de stock en la misma
        protected $table = 'productos';

        // Nombres de las columnas que son rellenables
        protected $fillable = [
        'codigo_producto', 'stock_disponible', 'stock_minimo', 'stock_deseado', 'activo', 'id_proveedor', 'id_marca', 'id_categoria'
        ];
        
        // INNER JOIN con la tabla Proveedores por medio de la FK id_proveedor
        public function proveedor() {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
        }
        // INNER JOIN con la tabla Marcas por medio de la FK id_marca
        public function marca() {
        return $this->belongsTo(Marca::class, 'id_marca');
        }
        // INNER JOIN con la tabla Categorias por medio de la FK id_categoria
        public function categoria() {
            return $this->belongsTo(Categoria::class, 'id_categoria');
        }

}
