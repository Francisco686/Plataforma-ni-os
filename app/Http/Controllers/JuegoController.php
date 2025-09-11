<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partida;
use App\Models\Logro;
use Illuminate\Support\Facades\Auth;

class JuegoController extends Controller
{
    public function guardarPartida(Request $request, $tipo)
    {
        $user = Auth::user();

        // Validar los datos recibidos
        $data = $request->validate([
            'tiempo_resolucion' => 'required|numeric|min:1', // Tiempo debe ser un número positivo
            'errores' => 'required|integer|min:0', // Errores debe ser un entero no negativo
        ]);

        // Guardar partida
        $partida = Partida::create([
            'user_id' => $user->id,
            'tipo' => $tipo, // Ejemplo: 'sopa', 'memorama', 'clasificacion'
            'tiempo_resolucion' => $data['tiempo_resolucion'],
            'errores' => $data['errores'],
        ]);

        // Verificar logros por número de partidas y condiciones específicas
        $total = $user->partidas()->where('tipo', $tipo)->count();
        $nuevoLogro = null;

        $logros = [
            ['nombre' => 'Jugador Novato', 'meta' => 1, 'condicion' => 'partidas'],
            ['nombre' => 'Jugador Intermedio', 'meta' => 20, 'condicion' => 'partidas'],
            ['nombre' => 'Jugador Avanzado', 'meta' => 30, 'condicion' => 'partidas'],
            ['nombre' => 'Rápido como el Viento', 'meta' => 60, 'condicion' => 'tiempo_sopa'],
            ['nombre' => 'Clasificador Perfecto Memorama', 'meta' => 0, 'condicion' => 'errores_memorama'],
            ['nombre' => 'Clasificador Perfecto Clasificación', 'meta' => 0, 'condicion' => 'errores_clasificacion'],
        ];

        foreach ($logros as $logro) {
            $logroDB = Logro::where('nombre', $logro['nombre'])->first();
            if (!$logroDB || $user->logros->contains($logroDB->id)) {
                continue;
            }

            $desbloquear = false;
            if ($logro['condicion'] === 'partidas') {
                $desbloquear = ($total >= $logro['meta']);
            } elseif ($logro['condicion'] === 'tiempo_sopa' && $tipo === 'sopa') {
                $desbloquear = ($data['tiempo_resolucion'] <= $logro['meta']);
            } elseif ($logro['condicion'] === 'errores_memorama' && $tipo === 'memorama') {
                $desbloquear = ($data['errores'] === $logro['meta']);
            } elseif ($logro['condicion'] === 'errores_clasificacion' && $tipo === 'clasificacion') {
                $desbloquear = ($data['errores'] === $logro['meta']);
            }

            if ($desbloquear) {
                $user->logros()->attach($logroDB->id, ['fecha_obtenido' => now()]);
                $nuevoLogro = $logroDB->nombre;
            }
        }

        return response()->json([
            'success' => true,
            'mensaje' => 'Partida guardada y logros verificados.',
            'partida' => $partida,
            'nuevo_logro' => $nuevoLogro,
        ]);
    }
}
