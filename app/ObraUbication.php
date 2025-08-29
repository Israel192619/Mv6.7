<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObraUbication extends Model
{
    use HasFactory;
    protected $fillable = [
        'obra_id',
        'ubicacion',
        /* 'fecha_inicio',
        'fecha_fin', */
    ];

    public function obra()
    {
        return $this->belongsTo(Obra::class);
    }
}
