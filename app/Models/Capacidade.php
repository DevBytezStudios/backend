<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Capacidade extends Model
{
    protected $fillable = [
        'id_con',
        'limite'
    ];
    /** @use HasFactory<\Database\Factories\CapacidadeFactory> */
    use HasFactory;
}
