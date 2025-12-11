<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Produto extends Model
{

    protected $fillable = [
        'id_con',
        'id_cat',
        'nome',
        'imagem',
        'valor',
        'valor_desc',
        "descricao"
    ];

    /** @use HasFactory<\Database\Factories\ProdutoFactory> */
    use HasFactory;

    protected function imagem(): Attribute
    {
        // PEGAR A URL DA IMAGEM COMPLETA AO PEDIR ELA
        return Attribute::make(
            get: function ($imagem) {
                if (Storage::disk('public')->exists("produtos/" . $imagem)) {
                    return Storage::url("produtos/" . $imagem);
                } else {
                    return Storage::url("semImagem.jpg");
                }
            },

            set: fn($imagem) => $imagem
        );
    }


    public function categoria(): HasOne
    {
        return $this->hasOne(Categoria::class, 'id', 'id_cat')->select('id', 'titulo');
    }
}
