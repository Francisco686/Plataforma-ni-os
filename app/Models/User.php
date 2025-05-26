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

    public function talleresAsignados()
    {
        return $this->belongsToMany(Taller::class, 'asigna_tallers', 'user_id', 'taller_id')
            ->withTimestamps();
    }

    public function talleres()
    {
        return $this->belongsToMany(Taller::class, 'alumno_taller');
    }

    public function respuestas()
    {
        return $this->hasMany(\App\Models\RespuestaAlumno::class);
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
    public function logros()
{
    return $this->belongsToMany(Logro::class)->withPivot('fecha_obtenido');
}

public function partidas()
{
    return $this->hasMany(Partida::class);
}
public function user()
{
    return $this->belongsTo(User::class);
}



}
