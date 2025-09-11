<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'password',
        'grupo_id'
    ];

    public function grupo() {
        return $this->belongsTo(\App\Models\Group::class, 'grupo_id');
    }

}
