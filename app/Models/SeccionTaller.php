<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeccionTaller extends Model
{
    use HasFactory;

    protected $table = 'seccion_tallers';
    protected $fillable = ['taller_id', 'nombre', 'descripcion', 'orden'];

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }

    public function progresos()
    {
        return $this->hasMany(ProgresoTaller::class, 'seccion_taller_id');
    }
}
