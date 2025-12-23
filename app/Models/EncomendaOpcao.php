<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncomendaOpcao extends Model
{

    protected $fillable = [
        "id_encomenda",
        "etapa",
        "nome",
        "valor"
    ];
    /** @use HasFactory<\Database\Factories\EncomendaOpcaoFactory> */
    use HasFactory;
}
