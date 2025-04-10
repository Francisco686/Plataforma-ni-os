<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresoTaller extends Model
{
    protected $fillable = [
        'asigna_taller_id',
        'seccion_taller_id',
        'completado',
        'fecha_completado',
    ];

    public function asignacion()
    {
        return $this->belongsTo(AsignaTaller::class, 'asigna_taller_id');
    }
}
