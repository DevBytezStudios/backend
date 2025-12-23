<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Estilo extends Model
{

    protected $fillable = [
        'titulo',
        'descricao',
        'imagem',
        'active',
        'valor',
    ];

    /** @use HasFactory<\Database\Factories\ConfeitariaFactory> */
    use HasFactory;
    protected $casts = ['active' => 'boolean'];

    protected function imagem(): Attribute
    {
        // PEGAR A URL DA IMAGEM COMPLETA AO PEDIR ELA
        return Attribute::make(
            get: function ($imagem) {
                if (Storage::disk('public')->exists("estilos/" . $imagem)) {
                    return Storage::url("estilos/" . $imagem);
                } else {
                    return Storage::url("semImagem.jpg");
                }
            },

            set: fn($imagem) => $imagem
        );
    }
}
