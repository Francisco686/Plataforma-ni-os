<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'role',
        'password',
        'password_visible',
        'grupo_id',
        'gmail',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
    // app/Models/User.php (Alumno)


    // app/Models/User.php
    public function sesiones()
    {
        return $this->belongsToMany(SesionActividad::class, 'actividad_estudiante', 'estudiante_id', 'actividad_id')
            ->withPivot(['estado', 'fecha_inicio', 'fecha_completado', 'respuesta'])
            ->withTimestamps();
    }
    public function talleres(): BelongsToMany
    {
        return $this->belongsToMany(Taller::class, 'asigna_tallers');
    }

    // app/Models/User.php
    // app/Models/User.php
    public function actividades()
    {
        return $this->belongsToMany(Actividad::class, 'actividad_estudiantes', 'estudiante_id', 'actividad_id')
            ->withPivot(['estado', 'fecha_inicio', 'fecha_completado', 'respuesta'])
            ->withTimestamps();
    }

    // Versión en inglés
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'grupo_id');
    }
    public function grupo()
    {
        return $this->belongsTo(Group::class, 'grupo_id'); // Especifica la columna correcta
    }

// Versión en español (usa la versión inglesa internamente)

    public function isDocente()
    {
        return $this->role === 'docente';
    }
    public function isAlumno()
    {
        return $this->role === 'alumno';
    }
    public function logros()
    {
        return $this->belongsToMany(Logro::class)->withPivot('fecha_obtenido');
    }

    public function partidas()
    {
        return $this->hasMany(Partida::class);
    }

    public function respuestas() {
        return $this->hasMany(RespuestaSesion::class, 'estudiante_id');
    }

    public function talleresAsignados() {
        return $this->hasMany(TallerAsignado::class);
    }

// app/Models/User.php (Alumno)





}
