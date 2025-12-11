<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Confeitaria;
use App\Models\Produto;
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
        return [
            "id_con" => 1,
            "id_cliente" => 1,
            "pagamento" => 'Pix',
            "code" => '123ABC',
            'data' => now(),
        ];
    }
}
