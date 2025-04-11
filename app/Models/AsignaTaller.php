<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignaTaller extends Model
{
    use HasFactory;

    protected $table = 'asigna_tallers';
    protected $fillable = ['user_id', 'taller_id', 'fecha_inicio'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taller()
    {
        return $this->belongsTo(Taller::class);
    }

    public function progresos()
    {
        return $this->hasMany(ProgresoTaller::class, 'asigna_taller_id');
    }
}
