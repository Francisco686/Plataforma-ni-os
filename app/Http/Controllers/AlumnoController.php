<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Group;

class AlumnoController extends Controller
{
    public function index(Request $request)
    {
        $grados = Group::pluck('grado')->unique()->sort();

        // Letras únicas de grupos, filtradas por grado si aplica
        $letrasQuery = Group::select('grupo')->distinct()->orderBy('grupo');
        if ($request->filled('grado')) {
            $letrasQuery->where('grado', $request->grado);
        }
        $letras = $letrasQuery->pluck('grupo');

        $consulta = User::where('role', 'alumno')
            ->leftJoin('groups', 'users.grupo_id', '=', 'groups.id') // Join with groups table
            ->select('users.*'); // Select all user fields

        // Filtro por grado
        if ($request->filled('grado')) {
            $consulta->where('groups.grado', $request->grado);
        }

        // Filtro por grupo (letra, no ID)
        if ($request->filled('grupo')) {
            $consulta->where('groups.grupo', strtolower($request->grupo));
        }

        // Buscador por nombre/apellido
        if ($request->filled('search')) {
            $search = $request->search;
            $consulta->where(function($q) use ($search) {
                $q->where('users.name', 'like', "%$search%")
                    ->orWhere('users.apellido_paterno', 'like', "%$search%")
                    ->orWhere('users.apellido_materno', 'like', "%$search%");
            });
        }

        // Ordenar por grado, grupo, apellido_paterno, apellido_materno, name
        $consulta->orderBy('groups.grado', 'asc')
            ->orderBy('groups.grupo', 'asc')
            ->orderBy('users.apellido_paterno', 'asc')
            ->orderBy('users.apellido_materno', 'asc')
            ->orderBy('users.name', 'asc');

        $alumnos = $consulta->get();
        $total = $alumnos->count();

        return view('alumnos.index', compact('alumnos', 'letras', 'grados', 'total'));
    }

    public function create()
    {
        return view('alumnos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'grado' => 'required|integer',
            'grupo' => 'required|string|max:1'
        ]);

        $grupo = Group::where('grado', $request->grado)
                      ->where('grupo', $request->grupo)
                      ->first();

        if (!$grupo) {
            return back()->withErrors(['grupo' => 'El grupo especificado no existe.'])->withInput();
        }

        $alumno = new User();
        $alumno->name = strtoupper($request->nombre);
        $alumno->apellido_paterno = strtoupper($request->apellido_paterno);
        $alumno->apellido_materno = strtoupper($request->apellido_materno);
        $alumno->password = Hash::make($request->password);
        $alumno->password_visible = $request->password;
        $alumno->role = 'alumno';
        $alumno->grupo_id = $grupo->id;
        $alumno->save();

        return redirect()->route('alumnos.index')->with('success', 'Alumno registrado correctamente.');
    }

    public function edit($id)
    {
        $alumno = User::findOrFail($id);
        return view('alumnos.edit', compact('alumno'));
    }

    public function update(Request $request, $id)
    {
        $alumno = User::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido_paterno' => 'required|string|max:255',
            'apellido_materno' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'grado' => 'required|integer',
            'grupo' => 'required|string|max:1'
        ]);

        $grupo = Group::where('grado', $request->grado)
                      ->where('grupo', $request->grupo)
                      ->first();

        if (!$grupo) {
            return back()->withErrors(['grupo' => 'El grupo especificado no existe.'])->withInput();
        }

        $alumno->name = strtoupper($request->nombre);
        $alumno->apellido_paterno = strtoupper($request->apellido_paterno);
        $alumno->apellido_materno = strtoupper($request->apellido_materno);

        if ($request->password) {
            $alumno->password = Hash::make($request->password);
            $alumno->password_visible = $request->password;
        }

        $alumno->grupo_id = $grupo->id;
        $alumno->save();

        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy($id)
    {
        $alumno = User::findOrFail($id);

        if ($alumno->role !== 'alumno') {
            return redirect()->route('alumnos.index')->with('error', 'Solo puedes eliminar alumnos desde esta sección.');
        }

        $alumno->delete();

        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }

    public function show($id)
    {
        $alumno = User::with('grupo')->findOrFail($id);
        return view('alumnos.show', compact('alumno'));
    }
}
