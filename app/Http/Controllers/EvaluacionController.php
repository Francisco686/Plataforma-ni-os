<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SesionActividad;
use App\Models\ActividadEstudiante;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    public function index(Request $request)
    {
        // Obtener grados y letras únicas para los filtros
        $grados = Group::pluck('grado')->unique()->sort();
        $letrasQuery = Group::select('grupo')->distinct()->orderBy('grupo');
        if ($request->filled('grado')) {
            $letrasQuery->where('grado', $request->grado);
        }
        $letras = $letrasQuery->pluck('grupo');

        // Consulta de alumnos con filtros
        $consulta = User::where('role', 'alumno')
            ->with(['group' => function($query) {
                $query->select('id', 'grado', 'grupo');
            }]);

        // Filtro por grado
        if ($request->filled('grado')) {
            $consulta->whereHas('group', function($q) use ($request) {
                $q->where('grado', $request->grado);
            });
        }

        // Filtro por grupo (letra)
        if ($request->filled('grupo')) {
            $consulta->whereHas('group', function($q) use ($request) {
                $q->where('grupo', strtolower($request->grupo));
            });
        }

        // Buscador por nombre/apellido
        if ($request->filled('search')) {
            $search = $request->search;
            $consulta->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('apellido_paterno', 'like', "%$search%")
                    ->orWhere('apellido_materno', 'like', "%$search%");
            });
        }

        // Ordenar por grado, grupo, apellido_paterno, apellido_materno, name
        $consulta->join('groups', 'users.grupo_id', '=', 'groups.id')
            ->orderBy('groups.grado', 'asc')
            ->orderBy('groups.grupo', 'asc')
            ->orderBy('users.apellido_paterno', 'asc')
            ->orderBy('users.apellido_materno', 'asc')
            ->orderBy('users.name', 'asc')
            ->select('users.*'); // Asegura que solo se seleccionen los campos de users

        $alumnos = $consulta->get();

        // Obtener todas las sesiones con sus actividades
        $sesiones = SesionActividad::with(['docente', 'actividades'])->get();

        // Forzar Carbon en created_at
        foreach ($sesiones as $sesion) {
            $sesion->created_at = Carbon::parse($sesion->created_at);
        }

        // Obtener todas las actividades de los alumnos
        $actividadesAlumno = [];
        foreach ($alumnos as $alumno) {
            $actividadesAlumno[$alumno->id] = ActividadEstudiante::where('estudiante_id', $alumno->id)->get();
        }

        // Determinar URL de retorno
        $returnUrl = $request->session()->get('return_url', route('alumnos.index'));

        return view('evaluaciones.index', compact('alumnos', 'sesiones', 'actividadesAlumno', 'grados', 'letras', 'returnUrl'));
    }
}
