<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardapio extends Model
{
    protected $fillable = [
        'id_con',
        'titulo',
        'cor_princ',
        'cor_sec',
        'dt_inicio',
        'dt_fim',
        'active'
    ];

    protected $casts = ['dt_inicio' => 'date','dt_fim' => 'date'];
    
    /** @use HasFactory<\Database\Factories\CardapioFactory> */
    use HasFactory;
}
