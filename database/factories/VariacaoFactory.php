<?php

namespace Database\Factories;

use App\Models\Confeitaria;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variacao>
 */
class VariacaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_produto' => fake()->randomElement(Produto::pluck('id')),
            'titulo'=> fake()->word(),
        ];
    }
}
