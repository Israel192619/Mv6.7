<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'business_id',
        // 'ubicacion',
        // 'fecha_inicio',
        // 'fecha_fin',
    ];

    public function ubicaciones()
    {
        return $this->hasMany(ObraUbication::class);
    }
}
