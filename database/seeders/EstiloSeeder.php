<?php

namespace Database\Seeders;

use App\Models\Estilo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstiloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estilo::create([
            'id_con' => 1,
            'titulo' => "Teste estilo 2",
            'valor' => 10,
            'imagem' => "semImagem.jpg",
            'descricao' => "Teste de Estilo 2",
            "active" => false
        ]);
    }
}
