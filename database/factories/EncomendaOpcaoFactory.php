<?php

namespace Database\Factories;

use App\Models\Encomenda;
use App\Models\EtapaOpcao;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EncomendaOpcaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


    public function definition(): array
    {
        return [
            'id_encomenda' => fake()->randomElement(Encomenda::pluck('id')),
            // snapshot da escolha
            'etapa' => fake()->name(),
            'nome'  => fake()->name(),
            'valor' => fake()->numberBetween(10,2),
        ];
    }
}
