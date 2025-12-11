<?php

namespace Database\Factories;

use App\Models\Confeitaria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\categoria>
 */
class CategoriaFactory extends Factory
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
            // "titulo" => 'Bolos',
            "titulo" => fake()->word(),
        ];
    }
}
