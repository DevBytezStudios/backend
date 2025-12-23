<?php

namespace Database\Seeders;

use App\Models\categoria;
use App\Models\Cliente;
use App\Models\Confeitaria;
use App\Models\Encomenda;
use App\Models\EncomendaOpcao;
use App\Models\Estilo;
use App\Models\Etapa;
use App\Models\EtapaOpcao;
use App\Models\Opcao;
use App\Models\Produto;
use App\Models\User;
use App\Models\Variacao;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Confeitaria::factory(1)->create();
        // categoria::factory(5)->create();
        // Produto::factory(30)->create();
        // Variacao::factory(5)->create();
        // Opcao::factory(10)->create();
        // Cliente::factory(1)->create();    
          
        // SISTEMA DE ENCOMENDA
        // Estilo::factory(1)->create();
        // Etapa::factory(5)->create();
        // EtapaOpcao::factory(10)->create();
        // Encomenda::factory(5)->create();
        // EncomendaOpcao::factory(10)->create();
    }
}
