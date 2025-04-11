<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'curp',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con los talleres asignados
     */
    public function talleresAsignados()
    {
        return $this->belongsToMany(Taller::class, 'asigna_tallers', 'user_id', 'taller_id')
            ->withPivot('fecha_inicio')
            ->using(AsignaTaller::class);
    }

    /**
     * Relación con las asignaciones de talleres
     */
    public function asignaciones()
    {
        return $this->hasMany(AsignaTaller::class, 'user_id');
    }

    /**
     * Verifica si el usuario es administrador
     */
    public function isAdmin()
    {
        return $this->role === 'administrador';
    }

    /**
     * Verifica si el usuario es docente
     */
    public function isDocente()
    {
        return $this->role === 'docente';
    }

    /**
     * Verifica si el usuario es alumno
     */
    public function isAlumno()
    {
        return $this->role === 'alumno';
    }
}
