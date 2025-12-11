<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcao extends Model
{

     protected $fillable = [
        'id_con',
        'id_var',
        'nome',
        'valor'
    ];


    /** @use HasFactory<\Database\Factories\OpcaoFactory> */
    use HasFactory;
}
