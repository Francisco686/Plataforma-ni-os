<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SesionActividad;
use App\Models\ActividadEstudiante;
use App\Models\Group;
use Carbon\Carbon;
class EvaluacionController extends Controller
{
    public function index()
    {
        // Obtener todos los alumnos
        $alumnos = User::where('role', 'alumno')
            ->with(['group' => function($query) {
                $query->select('id', 'grado', 'grupo');
            }])
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->orderBy('name')
            ->get();

        // Obtener todas las sesiones con sus actividades
        $sesiones = SesionActividad::with(['docente', 'actividades'])->get();

        // Forzar Carbon en created_at
        foreach ($sesiones as $sesion) {
            $sesion->created_at = Carbon::parse($sesion->created_at);
        }

        // Obtener todas las actividades de los alumnos
        $actividadesAlumno = [];
        foreach($alumnos as $alumno) {
            $actividadesAlumno[$alumno->id] = ActividadEstudiante::where('estudiante_id', $alumno->id)->get();
        }

        return view('evaluaciones.index', compact('alumnos', 'sesiones', 'actividadesAlumno'));
    }
}
