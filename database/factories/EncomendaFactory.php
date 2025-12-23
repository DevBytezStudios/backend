<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Confeitaria;
use App\Models\Estilo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Encomenda>
 */
class EncomendaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
          return [
            'id_con' => fake()->randomElement(Confeitaria::pluck('id')),
            'id_estilo' => fake()->randomElement(Estilo::pluck('id')),
            'id_cliente' => fake()->randomElement(Cliente::pluck('id')),
            'data_entrega' => fake()->dateTimeBetween('+1 days', '+15 days')->format('Y-m-d'),
            'status' => fake()->randomElement([
                'novo',
                'confirmado',
                'em_producao',
                'finalizado',
                'entregue',
                'cancelado',
            ]),

            // código 3 números + 3 letras
            'code' => fake()->numerify('###') . Str::upper(fake()->lexify('???')),
            'observacao' => fake()->boolean(40)
                ? fake()->sentence()
                : '',
        ];
    }
}
