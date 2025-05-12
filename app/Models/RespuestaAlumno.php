<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class RespuestaAlumno extends Model
{
    protected $table = 'respuestas_alumno';

    protected $fillable = [
        'user_id', 'seccion_id', 'respuesta', 'es_correcta'
    ];

    public function seccion()
    {
        return $this->belongsTo(SeccionTaller::class);
    }

    public function alumno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
