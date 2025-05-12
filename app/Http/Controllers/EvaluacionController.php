<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class EvaluacionController extends Controller
{
    public function index()
    {
        // Solo docentes o admin pueden acceder
        if (!in_array(Auth::user()->role, ['docente', 'administrador'])) {
            abort(403, 'No autorizado.');
        }

        $grupo = Auth::user()->grupo;

        // Si no hay grupo asignado, no se cargan alumnos
        $alumnos = $grupo
            ? $grupo->alumnos()
                ->where('role', 'alumno')
                ->with(['grupo', 'talleresAsignados.taller', 'talleresAsignados.progresos'])
                ->get()
            : collect(); // colección vacía si no hay grupo

        return view('evaluaciones.index', compact('alumnos'));
    }
}
