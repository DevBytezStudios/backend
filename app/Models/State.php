<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
{
    protected $fillable = [
        'id',
        'id_con',
        'state'
    ];
    /** @use HasFactory<\Database\Factories\StateFactory> */
    use HasFactory;

}
