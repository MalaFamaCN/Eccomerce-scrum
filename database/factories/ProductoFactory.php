<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;
use App\Models\Marca;
use App\Models\Proveedor;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    public function definition() {
        // Traemos una marca de manera aleatoria de la BD y lo convertimos en un objeto de PHP.
        $marca = Marca::inRandomOrder()->first();
        // Traemos una categoria de manera aleatoria de la BD y lo convertimos en un objeto de PHP.
        $categoria = Categoria::inRandomOrder()->first();
        // Traemos un Proveedor de manera aleatoria de la BD y lo convertimos en un objeto de PHP.
        $proveedor = Proveedor::inRandomOrder()->first(); 
        return [
        'codigo_producto' => $this->faker->numberBetween(1,10), // Una linea aleatoria
        'nombre' => $this->faker->sentence(), // Una linea aleatorio
        'descripcion' => $this->faker->paragraph(), // Un párrafo aleatorio
        'precio' => $this->faker->randomFloat(2, 2000, 100000), // Numero Flotante aleatorio en el rango [2000; 100000] con 2 decimales
        'stock_disponible' => $this->faker->numberBetween(1,10),
        'stock_minimo' => $this->faker->numberBetween(1,10),
        'stock_deseado' => $this->faker->numberBetween(1,10),
        'url_imagen' => $this->faker->imageUrl(640, 480), // URL de una imagen aleatoria con dimension 640x480
        'id_categoria' => $categoria->id, // FK de la categoria extraida anteriormente
        'id_marca' => $marca->id, // FK del marca extraido anteriormente
        'id_proveedor' => $proveedor->id, // FK del proveedor extraido anteriormente 
        ]; 
        }
        
}
