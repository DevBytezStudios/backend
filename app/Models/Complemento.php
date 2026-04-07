<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complemento extends Model
{

    protected $fillable = [
        'id_prod',
        'titulo'
    ];

    /** @use HasFactory<\Database\Factories\ComplementoFactory> */
    use HasFactory;
}
