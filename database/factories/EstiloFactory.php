<?php

namespace Database\Factories;

use App\Models\Confeitaria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estilo>
 */
class EstiloFactory extends Factory
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

            'titulo' => fake()->randomElement([
                'Bolo Clássico',
                'Bolo Infantil',
                'Bolo Floral',
                'Bolo Minimalista',
                'Bolo Temático',
                'Bolo Moderno',
            ]),

            'descricao' => fake()->sentence(10),

            // URL de banco de imagens (placeholder estável)
            'imagem' => fake()->randomElement([
                'https://images.unsplash.com/photo-1601972599720-bd0b1b56b5c2',
                'https://images.unsplash.com/photo-1605472565941-2e40b93d6bb0',
                'https://images.unsplash.com/photo-1606890737304-57a1ca8a5b62',
                'https://images.unsplash.com/photo-1603079840981-2f47f38d1b2a',
                'https://images.unsplash.com/photo-1612198791364-66f08f1c3f1b',
            ]),

            'active' => fake()->boolean(85),

            'valor' => fake()->randomFloat(2, 50, 300),
        ];
    }
}
