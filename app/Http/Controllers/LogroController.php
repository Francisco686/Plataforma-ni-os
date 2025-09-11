<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Logro;
use Illuminate\Http\Request;

class LogroController extends Controller
{
    public function index(Request $request)
    {
        \Log::info('LogroController index called at ' . now()->toDateTimeString());
        if (!Auth::check()) {
            \Log::warning('User not authenticated, redirecting to login');
            return redirect()->route('login')->with('error', 'Por favor inicia sesión para ver tus logros.');
        }

        $user = Auth::user();
        \Log::info('LogroController index accessed by user: ' . $user->id);

        // ---------------------------
        // 🔹 Estadísticas de Partidas
        // ---------------------------
        $partidas = $user->partidas();

        // Helper para armar estadísticas de cada juego
        $getStats = function($tipo) use ($partidas) {
            $query = (clone $partidas)->where('tipo', $tipo);

            return [
                'total' => $query->count(),
                'promedio_tiempo' => round($query->whereNotNull('tiempo_resolucion')->avg('tiempo_resolucion') ?? 0, 1),
                'mejor_tiempo' => $query->whereNotNull('tiempo_resolucion')->min('tiempo_resolucion'),
                'promedio_errores' => round($query->whereNotNull('errores')->avg('errores') ?? 0, 1),
                'mejor_errores' => $query->whereNotNull('errores')->min('errores'),
            ];
        };

        $stats = [
            'sopa' => $getStats('sopa'),
            'memorama' => $getStats('memorama'),
            'clasificacion' => $getStats('clasificacion'),
        ];

        // ---------------------------
        // 🔹 Logros
        // ---------------------------
        $logros = $user->logros()->get();
        $logrosNoDesbloqueados = Logro::whereDoesntHave('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        \Log::info('Logros no desbloqueados: ', $logrosNoDesbloqueados->toArray());

        return view('logros.index', compact('logros', 'logrosNoDesbloqueados', 'stats'));
    }
}
