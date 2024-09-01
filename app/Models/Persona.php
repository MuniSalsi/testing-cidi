<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Persona extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'cuil',
        'cuil_formateado',
        'nombre_autopercibido',
        'apellido',
        'nombre',
        'nombre_formateado',
        'fecha_nacimiento',
        'tel_formateado',
        'cel_formateado',
        'estado',
        'id_numero',
        'direccion_id'
    ];

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Domicilio::class, 'direccion_id');
    }
}
