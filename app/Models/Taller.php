<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taller extends Model
{
    use HasFactory;

    protected $table = 'tallers'; // ← aquí defines el nombre real

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function secciones()
    {
        return $this->hasMany(SeccionTaller::class);
    }
    public function usuariosAsignados()
    {
        return $this->belongsToMany(User::class, 'asigna_tallers', 'taller_id', 'user_id')
            ->withTimestamps();
    }

    public function progresoCompletado($asignaId)
    {
        $seccionesIds = $this->secciones()->pluck('id');

        return ProgresoTaller::where('asigna_taller_id', $asignaId)
            ->whereIn('seccion_taller_id', $seccionesIds)
            ->where('completado', true)
            ->count();
    }
}
