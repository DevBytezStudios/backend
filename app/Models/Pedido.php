<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'id_con',
        'id_cliente',
        'pagamento',
        'code',
        'data',
        'status'
    ];


    /** @use HasFactory<\Database\Factories\PedidoFactory> */
    use HasFactory;
}
