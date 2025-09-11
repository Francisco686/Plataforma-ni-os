<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $fillable = ['user_id', 'tipo', 'tiempo_resolucion', 'errores'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
