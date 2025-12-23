<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EtapaOpcao extends Model
{
    protected $fillable = [
        'id',
        'id_etapa',
        'nome',
        'valor',
        'descricao',
        'active'
    ];
    /** @use HasFactory<\Database\Factories\EtapaOpcaoFactory> */
    use HasFactory;
    protected $casts = ['active' => 'boolean'];

    public function etapa(): BelongsTo{
        return $this->belongsTo(Etapa::class,'id_etapa','id')->select('id','nome');
    }
}
