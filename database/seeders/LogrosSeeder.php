<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Logro;

class LogrosSeeder extends Seeder
{
    public function run()
    {
        Logro::create([
            'nombre' => 'Explorador Ecológico',
            'descripcion' => 'Completó su primer taller sobre el medio ambiente.',
            'icono' => 'img/logros/explorador.png',
        ]);

        Logro::create([
            'nombre' => 'Maestro del Reciclaje',
            'descripcion' => 'Acertó todas las preguntas del test de reciclaje.',
            'icono' => 'img/logros/reciclaje.png',
        ]);

        Logro::create([
            'nombre' => 'Guardian del Agua',
            'descripcion' => 'Completó todas las actividades del Taller del Agua.',
            'icono' => 'img/logros/agua.png',
        ]);
    }
}
