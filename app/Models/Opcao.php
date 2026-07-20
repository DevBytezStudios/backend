<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Opcao extends Model
{

    protected $fillable = [
        'id_comp',
        'nome',
        'valor'
    ];

    protected $casts = ['valor' => 'decimal'];

    /** @use HasFactory<\Database\Factories\OpcaoFactory> */
    use HasFactory;

    public function pedidoItems(): BelongsToMany
    {
        return $this->belongsToMany(pedido_item::class, 'pedido_item_opcaos','id_opcao','id');
    }
}
