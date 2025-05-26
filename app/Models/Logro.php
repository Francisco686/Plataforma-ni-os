<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logro extends Model
{
    protected $fillable = ['nombre', 'descripcion', 'icono'];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('fecha_obtenido')->withTimestamps();
    }
}
