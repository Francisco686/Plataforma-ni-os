<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActividadEstudiante extends Model
{
    protected $fillable = [
        'actividad_id',
        'estudiante_id',
        'taller_id',
        'docente_id',
        'estado',
        'respuesta',
        'archivo_path',
        'fecha_inicio',
        'fecha_completado',
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    public function taller()
    {
        return $this->belongsTo(SesionActividad::class, 'taller_id');
    }
    public function respuestasAlumno()
    {
        return $this->hasManyThrough(
            \App\Models\ActividadEstudiante::class,
            \App\Models\Actividad::class,
            'sesion_actividad_id', // foreign key en Actividad
            'actividad_id',         // foreign key en ActividadEstudiante
            'id',                   // local key en SesionActividad
            'id'                    // local key en Actividad
        )->where('estudiante_id', auth()->id());
    }

}
