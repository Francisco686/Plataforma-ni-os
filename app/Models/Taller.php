<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    use HasFactory;

    protected $table = 'tallers'; // ← aquí defines el nombre real

    protected $fillable = [
        'titulo',
        'descripcion',
        'materiales',
    ];
    

    public function secciones()
    {
        return $this->hasMany(SeccionTaller::class);
    }
<<<<<<< HEAD
    public function usuariosAsignados()
    {
        return $this->belongsToMany(User::class, 'asigna_tallers', 'taller_id', 'user_id')
            ->withTimestamps();
    }
=======
    public function alumnos()
    {
    return $this->belongsToMany(User::class, 'alumno_taller');
    }

>>>>>>> e457cad67fa8f1f6e32c48ab7123547bc7c746de

    public function progresoCompletado($asignaId)
    {
        $seccionesIds = $this->secciones()->pluck('id');

        return ProgresoTaller::where('asigna_taller_id', $asignaId)
            ->whereIn('seccion_taller_id', $seccionesIds)
            ->where('completado', true)
            ->count();
    }
    public function respuestas()
{
    return $this->hasManyThrough(
        \App\Models\RespuestaAlumno::class,
        \App\Models\SeccionTaller::class,
        'taller_id', // foreign key in secciones
        'seccion_id', // foreign key in respuestas
        'id', // local key in taller
        'id'  // local key in seccion
    );
}

}
