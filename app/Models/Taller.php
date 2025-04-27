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
    public function alumnos()
    {
    return $this->belongsToMany(User::class, 'alumno_taller');
    }


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
