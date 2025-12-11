<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confeitaria extends Model
{

    protected $fillable = [
        'nome',
        'slug',
        'cor_princ',
        'cor_sec',
        'logo',
        'email',
        'password'
    ];

    /** @use HasFactory<\Database\Factories\ConfeitariaFactory> */
    use HasFactory;
}
