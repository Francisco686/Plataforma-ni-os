<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesionActividad extends Model {
    public $timestamps = true;

    protected $dates = ['created_at', 'updated_at'];

    // Especifica el nombre exacto de la tabla
    protected $table = 'sesiones_actividades';

    // Campos asignables masivamente
    protected $fillable = [
        'docente_id',
        'titulo',
        'descripcion'
    ];

    // Relación con el docente

    public function respuestasAlumno()
    {
        return $this->hasManyThrough(
            \App\Models\ActividadEstudiante::class,
            \App\Models\Actividad::class,
            'sesion_id',
            'actividad_id',
            'id',
            'id'
        )->where('estudiante_id', auth()->id());
    }

    public function respuestas() {
        return $this->hasMany(RespuestaSesion::class);
    }
    // app/Models/SesionActividad.php
    // app/Models/SesionActividad.php
    // app/Models/SesionActividad.php
    // app/Models/SesionActividad.php
    // app/Models/SesionActividad.php
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'sesion_id');
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(User::class, 'actividad_estudiante', 'actividad_id', 'estudiante_id')
            ->withPivot(['estado', 'fecha_inicio', 'fecha_completado', 'respuesta']);
    }
    







}
