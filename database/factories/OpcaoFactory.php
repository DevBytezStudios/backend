<?php

namespace Database\Factories;

use App\Models\Variacao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Opcao>
 */
class OpcaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_var' => fake()->randomElement(Variacao::pluck('id')),
            'nome' => fake()->name(),
            'valor' => fake()->numberBetween(5,100)
        ];
    }
}
