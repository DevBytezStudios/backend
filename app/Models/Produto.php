<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Produto extends Model
{

     protected $fillable = [
        'id_con',
        'id_cat',
        'nome',
        'imagem',
        'valor',
        'valor_desc'
    ];

    /** @use HasFactory<\Database\Factories\ProdutoFactory> */
    use HasFactory;

    protected function imagem(): Attribute
    {
        // PEGAR A URL DA IMAGEM COMPLETA AO PEDIR ELA
        return Attribute::get(function ($value) {
            if(Storage::disk('local')->exists("produtos/" . $value)){
                return Storage::url("produtos/" . $value);
            }else{
                return Storage::url("semImagem.jpg");
            }
        });
        
    }
}
