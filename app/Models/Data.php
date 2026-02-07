<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Data extends Model
{

    protected $fillable = [
        'id_con',
        'dt_bloq'
    ];
    /** @use HasFactory<\Database\Factories\DataFactory> */
    use HasFactory;

      public function state(): BelongsTo
    {
        return $this->belongsTo(Confeitaria::class, 'id_con', 'id');
    }
}
