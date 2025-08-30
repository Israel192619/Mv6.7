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
        // 'ubicacion',
        // 'fecha_inicio',
        // 'fecha_fin',
    ];

    public function ubicaciones()
    {
        return $this->hasMany(ObraUbication::class);
    }
}
