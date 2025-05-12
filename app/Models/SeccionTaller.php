<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeccionTaller extends Model
{
    use HasFactory;

    protected $table = 'secciones_taller';

    protected $fillable = [
        'taller_id',
        'tipo',
        'titulo',
        'contenido',
        'opciones',
        'respuesta_correcta',
    ];

    protected $casts = [
        'contenido' => 'array',
        'opciones' => 'array',
        'respuesta_correcta' => 'array',
    ];

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }

    public function progresos()
    {
        return $this->hasMany(ProgresoTaller::class, 'seccion_taller_id');
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestaAlumno::class, 'seccion_id');
    }
}
