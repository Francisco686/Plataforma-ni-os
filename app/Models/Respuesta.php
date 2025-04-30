<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    protected $fillable = ['user_id', 'seccion_id', 'respuesta'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seccion()
    {
        return $this->belongsTo(SeccionTaller::class, 'seccion_id');
    }
}
