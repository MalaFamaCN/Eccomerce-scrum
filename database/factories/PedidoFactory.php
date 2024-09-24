<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\MetodoDePago;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pedido>
 */
class PedidoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $mdp = MetodoDePago::inRandomOrder()->first(); 

        return [
        'total' => $this->faker->randomFloat(2, 2000, 100000), // Numero Flotante aleatorio en el rango [2000; 100000] con 2 decimales
        /* 'fecha_hora' => $this->faker->date('Y-m-d'), */
        'direccion' => $this->faker->sentence(),
        'num_pedido' => $this->faker->randomNumber(),
        'num_seguimiento' => $this->faker->randomNumber(),
        'pagado' => false,
        'en_preparacion'=>false,
        'cancelado'=> false,
        'enviado'=> false,
        'id_cliente' => $user->id, 
        'id_metodo_de_pago' => $mdp->id, 
        ];
    }
}
