<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table = 'groups'; // Asegúrate que coincida con tu tabla

    protected $fillable = ['grado', 'grupo'];

    // app/Models/Group.php
    public function alumnos()
    {
        return $this->hasMany(User::class)->where('role', 'alumno');
    }


    public function getNombreAttribute() {
        return $this->grado . '°' . strtoupper($this->grupo);
    }
}
