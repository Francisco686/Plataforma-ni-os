<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use App\Models\User;
use App\Models\AsignaTaller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TallerController extends Controller
{
    /**
     * Muestra la vista principal con los talleres según el rol del usuario.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'administrador') {
            $talleres = Taller::with(['usuariosAsignados', 'secciones'])->withCount('secciones')->get();

            $talleres->each(function ($taller) {
                $taller->usuariosNoAsignados = User::where('role', 'alumno')
                    ->whereDoesntHave('talleresAsignados', function ($query) use ($taller) {
                        $query->where('taller_id', $taller->id);
                    })->get();
            });

            return view('talleres.index', [
                'talleres' => $talleres,
                'userId' => $user->id,
            ]);
        }

        if ($user->isDocente()) {
            $alumnos = User::where('role', 'alumno')
                ->where('grupo_id', $user->grupo_id)
                ->with('grupo')
                ->get();

            $talleres = Taller::with('alumnos')->latest()->get();
            $taller = $talleres->first(); // o selecciona el que necesites
            return view('talleres.talleres', compact('alumnos', 'talleres', 'taller'));
        }

        // Alumno
        $talleres = $user->talleres()->with('secciones')->get();

        return view('talleres.mis_talleres', compact('talleres'));
    }

    /**
     * Almacena un nuevo taller y lo asigna a alumnos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'destinatarios' => 'required|array',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $rutaArchivo = null;

        if ($request->hasFile('archivo')) {
            $rutaArchivo = $request->file('archivo')->store('materiales', 'public');
        }

        $taller = Taller::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'materiales' => $rutaArchivo,
        ]);

        $destinos = $request->destinatarios;

        if (in_array('all', $destinos)) {
            $destinos = User::where('role', 'alumno')
                ->where('grupo_id', Auth::user()->grupo_id)
                ->pluck('id')
                ->toArray();
        }

        $taller->alumnos()->attach($destinos);

        return back()->with('success', 'Taller creado y asignado correctamente.');
    }

    /**
     * Muestra el formulario de edición de un taller.
     */
    public function edit(Taller $taller)
    {
        $alumnos = User::where('role', 'alumno')->with('grupo')->get();
        return view('talleres.edit', compact('taller', 'alumnos'));
    }

    /**
     * Actualiza los datos de un taller.
     */
    public function update(Request $request, Taller $taller)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = [
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ];

        if ($request->hasFile('archivo')) {
            if ($taller->materiales && Storage::disk('public')->exists($taller->materiales)) {
                Storage::disk('public')->delete($taller->materiales);
            }

            $data['materiales'] = $request->file('archivo')->store('materiales', 'public');
        }

        $taller->update($data);

        return redirect()->route('talleres.index')->with('success', 'Taller actualizado correctamente.');
    }

    /**
     * Muestra el formulario para asignar talleres.
     */
    public function asignar()
    {
        $talleres = Taller::all();
        $users = User::where('role', 'docente')->get();

        return view('talleres.asignar', compact('talleres', 'users'));
    }

    /**
     * Almacena una nueva asignación de taller a un usuario.
     */
    public function storeAsignacion(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'taller_id' => 'required|exists:tallers,id',
            'fecha_inicio' => 'nullable|date',
        ]);

        AsignaTaller::firstOrCreate([
            'user_id' => $validated['user_id'],
            'taller_id' => $validated['taller_id'],
        ], [
            'fecha_inicio' => $validated['fecha_inicio'] ?? now(),
        ]);

        return back()->with('success', 'Taller asignado exitosamente');
    }

    /**
     * Muestra un taller con sus usuarios asignados y no asignados.
     */
    public function show($id)
    {
        $taller = Taller::with(['usuariosAsignados' => function ($query) {
            $query->select('users.id', 'users.name', 'users.email', 'users.role');
        }, 'secciones'])->findOrFail($id);

        $usuariosNoAsignados = User::whereDoesntHave('talleresAsignados', function ($query) use ($id) {
            $query->where('taller_id', $id);
        })->get() ?? collect();

        return view('talleres.show', compact('taller', 'usuariosNoAsignados'));
    }

    /**
     * Elimina un taller, su archivo y asignaciones.
     */
    public function destroy(Taller $taller)
    {
        $taller->alumnos()->detach();

        AsignaTaller::where('taller_id', $taller->id)->delete();

        if ($taller->materiales && Storage::disk('public')->exists($taller->materiales)) {
            Storage::disk('public')->delete($taller->materiales);
        }

        $taller->delete();

        return redirect()->route('talleres.index')->with('success', 'Taller eliminado correctamente.');
    }

    /**
     * Quita la asignación de un usuario a un taller.
     */
    public function destroyAsignacion(Taller $taller, User $usuario)
    {
        $taller->usuariosAsignados()->detach($usuario->id);

        return back()->with('success', 'Usuario removido del taller correctamente');
    }
}
