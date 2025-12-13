<?php

namespace Database\Seeders;

use App\Models\categoria;
use App\Models\Cliente;
use App\Models\Confeitaria;
use App\Models\Opcao;
use App\Models\Pedido;
use App\Models\pedido_item;
use App\Models\Produto;
use App\Models\User;
use App\Models\Variacao;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Confeitaria::factory(1)->create();
        categoria::factory(5)->create();
        Produto::factory(30)->create();
        Variacao::factory(5)->create();
        Opcao::factory(10)->create();
        Cliente::factory(1)->create();
        // Pedido::factory(10)->create();
        PedidoItemSeeder::class;
    }
}
