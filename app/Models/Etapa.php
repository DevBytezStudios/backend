<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Etapa extends Model
{
    protected $fillable = [
        'id',
        'id_con',
        'nome',
        'required',
        'icone',
        'ordem',
        'multiple'
    ];
    use HasFactory;

    protected $casts = ['required' => 'boolean', 'multiple' => 'boolean'];

    protected function icone(): Attribute
    {
        // PEGAR A URL DA IMAGEM COMPLETA AO PEDIR ELA
        return Attribute::make(
            get: function ($icone) {
                if (Storage::disk('public')->exists("etapas/" . $icone)) {
                    return Storage::url("etapas/" . $icone);
                } else {
                    return Storage::url("semImagem.jpg");
                }
            },

            set: fn($icone) => $icone
        );
    }



    // PEGAR OPCOES
    public function opcoes(): HasMany
    {
        return $this->hasMany(EtapaOpcao::class, 'id_etapa', 'id');
    }
}
