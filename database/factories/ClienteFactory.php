<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'telefone'    => $this->faker->numerify('###########'),
            'nome'        => $this->faker->name(),
            'cep'         => $this->faker->numerify('########'),
            'rua'         => $this->faker->streetName(),
            'complemento' => $this->faker->secondaryAddress(),
            'bairro'      => $this->faker->streetSuffix(),
            'numero'      => $this->faker->numberBetween(1, 9999),
            'cidade'      => $this->faker->city(),
        ];
    }
}
