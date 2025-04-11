<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Group;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = User::where('role', 'alumno')->with('grupo')->get();
        return view('alumnos.index', compact('alumnos'));
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
        $alumno->delete();

        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado correctamente.');
    }

    public function show($id)
    {
        $alumno = User::with('grupo')->findOrFail($id);
        return view('alumnos.show', compact('alumno'));
    }
}
