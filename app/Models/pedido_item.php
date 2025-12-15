<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    // PEGAR AS INFORMÇÔES DO PRODUTO
    public function produto(): BelongsTo
    {
        return $this->belongsTo(Produto::class, 'id_produto', 'id')
            ->select('id', 'nome', 'valor', 'valor_desc');
    }

    // PEGAR AS OPÇOES ESCOLHIDAS DE CADA PROUTO
    public function opcoes(): BelongsToMany
    {
        return $this->belongsToMany(Opcao::class, 'pedido_item_opcaos', 'id_pedido_item', 'id_opcao')->select('opcaos.id',"opcaos.nome","opcaos.valor");
    }
}
