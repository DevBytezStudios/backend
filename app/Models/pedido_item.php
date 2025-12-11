<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pedido_item extends Model
{

    protected $fillable = [
        'id_con',
        'id_produto',
        'id_pedido',
        'id_opcao',
        'quantidade',
    ];


    /** @use HasFactory<\Database\Factories\PedidoItemFactory> */
    use HasFactory;
}
