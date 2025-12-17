<?php

namespace Database\Seeders;

use App\Models\Confeitaria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfeitariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Confeitaria::create([
            'nome' => 'confeitaria1',
            'slug' => 'confeitaria1',
            'cor_princ' => "red",
            'cor_sec' => "blue",
            'logo' => 'semImagem',
            'email' => 'conf1@gmail.com',
            'password' => bcrypt('123'),
        ], [
            'nome' => 'confeitaria2',
            'slug' => 'confeitaria2',
            'cor_princ' => "red",
            'cor_sec' => "blue",
            'logo' => 'semImagem',
            'email' => 'conf2@gmail.com',
            'password' => bcrypt('123'),
        ]);
    }
}
