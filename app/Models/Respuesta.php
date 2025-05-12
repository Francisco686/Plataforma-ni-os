<?php
<<<<<<< HEAD

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
namespace App\Models;
>>>>>>> e457cad67fa8f1f6e32c48ab7123547bc7c746de
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
<<<<<<< HEAD
    use HasFactory;

    protected $fillable = [
        'id_seccion',
        'id_alumno',
        'pregunta1',
        'pregunta2',
        'pregunta3',
        'pregunta4',
        'pregunta5',
    ];
=======
    protected $fillable = ['user_id', 'seccion_id', 'respuesta'];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function seccion()
    {
        return $this->belongsTo(SeccionTaller::class, 'seccion_id');
    }
>>>>>>> e457cad67fa8f1f6e32c48ab7123547bc7c746de
}
