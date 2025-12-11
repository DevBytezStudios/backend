<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Confeitaria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
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
            // 'id_cat' => 1,
            'id_cat' => fake()->randomElement(Categoria::pluck('id')),
            'nome' => "Bolo de Chocolate",
            'imagem' => 'bolodechocolate.jpg',
            'valor' => 20.99,
            'descricao' => 'Bolo de chocolate com cobertura de brigadeiro (1kg)',
            'valor_desc' => 15.99,
        ];
    }
}
