<?php

namespace Database\Seeders;

use App\Models\pedido_item;
use App\Models\Produto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PedidoItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        pedido_item::factory()
            ->count(20)
            ->create([
                'id_con'     => 1,
                'id_produto' => fake()->randomElement(Produto::pluck('id')),
                'id_pedido'  => 1,
                'quantidade' => 5,
            ]);
    }
}
