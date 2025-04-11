<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['grado', 'grupo'];

    public function alumnos() {
        return $this->hasMany(\App\Models\Alumno::class);
    }

    public function getNombreAttribute() {
        return $this->grado . '°' . strtoupper($this->grupo);
    }
}
