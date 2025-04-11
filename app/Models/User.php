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
        'password_visible', // ← ESTA LÍNEA
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
        return $this->belongsTo(Group::class);
    }

    public function isDocente()
    {
        return $this->role === 'docente';
    }

    public function isAlumno()
    {
        return $this->role === 'alumno';
    }
}
