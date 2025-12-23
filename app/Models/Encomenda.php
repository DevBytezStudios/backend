<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Encomenda extends Model
{
        protected $fillable = [
                'id_con',
                'id_cliente',
                "id_estilo",
                'data_entrega',
                'status',
                'pagamento',
                'code',
                'observacao'
        ];
        use HasFactory;

        public function opcoes(): HasMany
        {
                return $this->hasMany(EncomendaOpcao::class, 'id_encomenda', 'id');
        }

        public function cliente(): HasOne
        {
                return $this->hasOne(Cliente::class, 'id', 'id_cliente')->select("id", 'nome', 'telefone', 'rua', 'cep', 'complemento', 'bairro', 'cidade', 'numero');
        }

        public function estilo(): HasOne{
                return $this->hasOne(Estilo::class,'id','id_estilo')->select('id','imagem','titulo','valor');
        }
}
