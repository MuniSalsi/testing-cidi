<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Domicilio extends Model
{
    use HasFactory;

    protected $table = 'domicilios';

    protected $fillable = [
        'pais',
        'provincia',
        'departamento',
        'localidad',
        'barrio',
        'calle',
        'numero',
        'codigo_postal',
        'piso',
        'departamento_calle',
        'torre',
        'manzana',
        'lote',
    ];

    public function personas(): HasMany
    {
        return $this->hasMany(Persona::class, 'direccion_id');
    }
}
