<?php

namespace Database\Factories;
use App\Models\Producto;
use App\Models\User;
use App\Models\Pedido;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetallePedidos>
 */
class DetallePedidosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $pedido = Pedido::inRandomOrder()->first(); 
        $producto = Producto::inRandomOrder()->first(); 

        return [
        'subtotal' => $producto->precio,
        'cant_producto' => $producto->stock_disponible,
        
        'id_cliente' => 5, // FK de la categoria extraida anteriormente
        'id_pedido' => $pedido->id ?? null, // FK del marca extraido anteriormente
        'id_producto' => $producto->id, // FK del proveedor extraido anteriormente 
        ];
    }
}
