<?php

namespace Database\Factories;

use App\Models\Confeitaria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Etapa>
 */
class EtapaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_con' => Confeitaria::query()->pluck('id')->random(),

            'nome' => fake()->randomElement([
                'Base',
                'Tamanho',
                'Massa',
                'Recheio',
                'Cobertura',
                'Estilo',
                'Acréscimos',
            ]),

            'ordem' => fake()->numberBetween(1, 10),

            'required' => fake()->boolean(70),
            'multiple' => fake()->boolean(30),
            'icone' => 'semImagem.jpg'
        ];
    }
}
