<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\pedido_item;


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

    // PEGAR O CLIENTE - LA ELE
    public function cliente(): HasOne
    {
        return $this->hasOne(Cliente::class, 'id', 'id_cliente')->select("id", 'nome', 'telefone', 'rua', 'cep', 'complemento', 'bairro', 'cidade', 'numero');
    }

    // 
    public function pedidoItem(): HasMany{
        return $this->hasMany(pedido_item::class,'id_pedido','id')->with(['produto', 'opcoes']);
    }
}
