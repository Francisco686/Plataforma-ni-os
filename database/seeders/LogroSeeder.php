<?php

use Illuminate\Database\Seeder;
use App\Models\Logro;

class LogroSeeder extends Seeder
{
    public function run(): void
    {
        Logro::insert([
            ['nombre' => 'Jugador Novato', 'descripcion' => 'Has jugado 5 veces'],
            ['nombre' => 'Jugador Intermedio', 'descripcion' => 'Has jugado 20 veces'],
            ['nombre' => 'Jugador Avanzado', 'descripcion' => 'Has jugado 30 veces'],
        ]);
    }
}
