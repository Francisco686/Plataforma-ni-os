<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'role',
        'password',
        'password_visible',
        'grupo_id',
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

    public function grupo()
    {
        return $this->belongsTo(Group::class, 'grupo_id');
    }
    
    public function isDocente()
    {
        return $this->role === 'docente';
    }

    public function isAlumno()
    {
        return $this->role === 'alumno';
    }

    public function talleresAsignados()
    {
        return $this->hasMany(AsignaTaller::class);
    }

    // Asignar automáticamente los talleres base a los alumnos
    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->role === 'alumno') {
                $talleres = \App\Models\Taller::all();

                foreach ($talleres as $taller) {
                    \App\Models\AsignaTaller::firstOrCreate([
                        'user_id' => $user->id,
                        'taller_id' => $taller->id,
                    ], [
                        'fecha_inicio' => now(),
                    ]);
                }
            }
        });
    }
}
