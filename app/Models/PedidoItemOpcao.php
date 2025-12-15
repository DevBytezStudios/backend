<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PedidoItemOpcao extends Model
{
    /** @use HasFactory<\Database\Factories\PedidoItemOpcaoFactory> */

    protected $fillable = [
        'id_pedido_item',
        'id_opcao'
    ];
    use HasFactory;


    public function opcoes(): HasOne{
        return $this->hasOne(Opcao::class,'id','id_opcao')->select('id','nome','valor');
    }
}
