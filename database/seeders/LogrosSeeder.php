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

        Logro::create([
            'nombre' => 'Jugador Novato',
            'descripcion' => 'Completar 1 partida de cualquier juego',
            'icono' => 'path/to/novato.png'
        ]);
        Logro::create([
            'nombre' => 'Jugador Intermedio',
            'descripcion' => 'Completar 20 partidas de cualquier juego',
            'icono' => 'path/to/intermedio.png'
        ]);
        Logro::create([
            'nombre' => 'Jugador Avanzado',
            'descripcion' => 'Completar 30 partidas de cualquier juego',
            'icono' => 'path/to/avanzado.png'
        ]);
        Logro::create([
            'nombre' => 'Rápido como el Viento',
            'descripcion' => 'Completar sopa de letras en menos de 60 segundos',
            'icono' => 'path/to/rapido.png'
        ]);
        Logro::create([
            'nombre' => 'Clasificador Perfecto Memorama',
            'descripcion' => 'Completar memorama sin errores',
            'icono' => 'path/to/perfecto_memorama.png'
        ]);
        Logro::create([
            'nombre' => 'Clasificador Perfecto Clasificación',
            'descripcion' => 'Completar clasificación sin errores',
            'icono' => 'path/to/perfecto_clasificacion.png'
        ]);
    }
}
