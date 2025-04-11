<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresoTaller extends Model
{
    use HasFactory;

    protected $table = 'progreso_tallers';
    protected $fillable = ['asigna_taller_id', 'seccion_taller_id', 'completado', 'fecha_completado'];

    public function asignacion()
    {
        return $this->belongsTo(AsignaTaller::class, 'asigna_taller_id');
    }

    public function seccion()
    {
        return $this->belongsTo(SeccionTaller::class, 'seccion_taller_id');
    }
}
