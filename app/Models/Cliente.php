<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $fillable = [
        'telefone',
        'nome',
        'cep',
        'rua',
        'complemento',
        'bairro',
        'numero',
        'cidade',
    ];


    /** @use HasFactory<\Database\Factories\ClienteFactory> */
    use HasFactory;
}
