<?php

namespace Database\Factories;

use App\Models\Opcao;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\pedido_item>
 */
class PedidoItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_con' => 1,
            'id_produto' => 1,
            'id_pedido' => fake()->randomElement(Produto::pluck('id')),
            'id_opcao' => fake()->randomElement(Opcao::pluck('id')),
            'quantidade' => 5
        ];
    }
}
