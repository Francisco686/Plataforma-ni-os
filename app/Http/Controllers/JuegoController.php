<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\Logro;
use Illuminate\Support\Facades\Auth;

class JuegoController extends Controller
{
    public function guardarPartida($tipo)
    {
        $user = Auth::user();

        // Guardar partida
        Partida::create([
            'user_id' => $user->id,
            'tipo' => $tipo, // ejemplo: 'sopa' o 'memorama'
        ]);

        // Verificar logros por número de partidas
        $total = $user->partidas()->count();

        $logros = [
            ['nombre' => 'Jugador Novato', 'meta' => 5],
            ['nombre' => 'Jugador Intermedio', 'meta' => 20],
            ['nombre' => 'Jugador Avanzado', 'meta' => 30],
        ];

        foreach ($logros as $logro) {
            $logroDB = Logro::where('nombre', $logro['nombre'])->first();
            if ($logroDB && $total >= $logro['meta'] && !$user->logros->contains($logroDB->id)) {
                $user->logros()->attach($logroDB->id, ['fecha_obtenido' => now()]);
            }
        }

        return response()->json(['mensaje' => 'Partida guardada y logros verificados.']);
    }
}
