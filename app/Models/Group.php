<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['grado', 'grupo'];

    public function alumnos()
{
    return $this->hasMany(User::class, 'grupo_id');
}


    public function getNombreAttribute() {
        return $this->grado . '°' . strtoupper($this->grupo);
    }
}
