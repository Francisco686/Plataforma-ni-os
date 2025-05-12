<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    use HasFactory;

    protected $table = 'tallers'; // Nombre real de la tabla

    protected $fillable = [
        'titulo',
        'descripcion',
        'materiales',
    ];

    /**
     * Relación con las secciones del taller.
     */
    public function secciones()
    {
        return $this->hasMany(SeccionTaller::class);
    }

    /**
     * Relación con usuarios asignados (pueden ser alumnos o docentes).
     */
    public function usuariosAsignados()
    {
        return $this->belongsToMany(User::class, 'asigna_tallers', 'taller_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Relación específica con alumnos (si se usa una tabla intermedia distinta).
     */
    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'alumno_taller');
    }

    /**
     * Obtiene el número de secciones completadas por un alumno (vía asignación).
     */
    public function progresoCompletado($asignaId)
    {
        $seccionesIds = $this->secciones()->pluck('id');

        return ProgresoTaller::where('asigna_taller_id', $asignaId)
            ->whereIn('seccion_taller_id', $seccionesIds)
            ->where('completado', true)
            ->count();
    }

    /**
     * Relación con respuestas de alumnos a través de las secciones del taller.
     */
    public function respuestas()
    {
        return $this->hasManyThrough(
            \App\Models\RespuestaAlumno::class,
            \App\Models\SeccionTaller::class,
            'taller_id',     // Foreign key en SeccionTaller
            'seccion_id',    // Foreign key en RespuestaAlumno
            'id',            // Clave local en Taller
            'id'             // Clave local en SeccionTaller
        );
    }
}
