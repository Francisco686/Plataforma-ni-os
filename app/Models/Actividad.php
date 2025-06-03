<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model {
    protected $fillable = [
        'sesion_id', // Asegúrate de incluir este campo
        'taller_id',
        'tipo',
        'pregunta',
        'contenido',
        'opciones',
        'respuesta_correcta',
        'video_url',
        'archivo_path',
        'permite_archivo',
        'puntos'
    ];
    protected $table = 'actividades';

    protected $casts = [
        'opciones' => 'array',
    ];

    public function respuestasAlumno()
    {
        return $this->hasMany(\App\Models\ActividadEstudiante::class, 'actividad_id');
    }
    // app/Models/Actividad.php
    // app/Models/Actividad.php
    // app/Models/Actividad.php
    // app/Models/Actividad.php
    // app/Models/Actividad.php
    public function sesion()
    {
        return $this->belongsTo(SesionActividad::class, 'sesion_id');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(User::class, 'actividad_estudiantes', 'actividad_id', 'estudiante_id')
            ->withPivot(['estado', 'fecha_inicio', 'fecha_completado', 'respuesta'])
            ->withTimestamps();
    }


}
