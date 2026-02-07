<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    protected $appends = ['logo_url'];
    protected $hidden = [
        'password',
        'created_at',
        'updated_at'
    ];


    /** @use HasFactory<\Database\Factories\ConfeitariaFactory> */
    use HasFactory;

    protected function logoUrl(): Attribute
    {
        // PEGAR A URL DA logo COMPLETA AO PEDIR ELA
        return Attribute::make(
            get: function ($logo) {
                if ($logo && Storage::disk('public')->exists("confeitarias/" . $logo)) {
                    return asset(Storage::url("confeitarias/" . $logo));
                }

                return asset('storage/semImagem.jpg');
            },

            set: fn($logo) => $logo
        );
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'id', 'id_con');
    }

    public function blockdates(): HasMany{
        return $this->hasMany(Data::class,'id_con','id')->select('id','id_con','dt_bloq');
    }
}
