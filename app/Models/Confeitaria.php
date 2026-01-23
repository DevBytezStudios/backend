<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class Confeitaria extends Authenticatable
{
    protected $fillable = [
        'id',
        'nome',
        'slug',
        'cor_princ',
        'cor_sec',
        'logo',
        'email',
        'password',
        'telefone'
    ];

    protected $hidden = [
        'password',
    ];

    /** @use HasFactory<\Database\Factories\ConfeitariaFactory> */
    use HasFactory;

    protected function logo(): Attribute
    {
        // PEGAR A URL DA logo COMPLETA AO PEDIR ELA
        return Attribute::make(
            get: function ($logo) {
                if (Storage::disk('public')->exists("confeitarias/" . $logo) || $logo != ' ') {
                    return Storage::url("confeitarias/" . $logo);
                } else {
                    return Storage::url("semImagem.jpg");
                }
            },

            set: fn($logo) => $logo
        );
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'id', 'id_con');
    }

}
