<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variacao extends Model
{

    protected $fillable = [
        'id_con',
        'id_produto',
        'titulo',
    ];


    /** @use HasFactory<\Database\Factories\VariacaoFactory> */
    use HasFactory;


    // PEGAR AS OPÇÔES DAQUELA VARIACAO
    public function opcoes(): HasMany{
        return $this->hasMany(Opcao::class,'id_var','id')->select('id', 'id_var', 'nome', 'valor');
    }
    
}
