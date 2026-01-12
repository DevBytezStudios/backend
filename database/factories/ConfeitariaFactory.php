<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Confeitaria>
 */
class ConfeitariaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => 'Doce Sabor',
            'slug' => 'confeitariateste',
            'cor_princ' => fake()->colorName(),
            'cor_sec' => fake()->colorName(),
            'logo' => 'semImagem',
            'email' => 'teste@gmail.com',
            'password' => Hash::make('senha123'),
        ];
    }
}
