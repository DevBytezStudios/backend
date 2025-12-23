<?php

namespace Database\Factories;

use App\Models\Etapa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EtapaOpcao>
 */
class EtapaOpcaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_etapa' => fake()->randomElement(Etapa::pluck('id')),
            'nome' => fake()->randomElement([
                'Pequeno',
                'Médio',
                'Grande',
                'Chocolate',
                'Baunilha',
                'Ninho',
                'Brigadeiro',
                'Vela',
                'Topper',
            ]),

            // valor pode ser zero ou maior
            'valor' => fake()->boolean(60)
                ? fake()->randomFloat(2, 5, 150)
                : 0.00,

            'descricao' => fake()->sentence(),
            'active' => fake()->boolean(85),
        ];
    }
}
