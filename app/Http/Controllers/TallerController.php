<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use App\Models\User;
use App\Models\AsignaTaller;
use Illuminate\Http\Request;

class TallerController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if($user->role === 'administrador') {
            $talleres = Taller::with(['usuariosAsignados', 'secciones'])->withCount('secciones')->get();

            // Para cada taller, obtenemos los usuarios ALUMNOS no asignados
            $talleres->each(function ($taller) {
                $taller->usuariosNoAsignados = User::where('role', 'alumno')
                    ->whereDoesntHave('talleresAsignados', function($query) use ($taller) {
                        $query->where('taller_id', $taller->id);
                    })->get();
            });

            return view('talleres.index', [
                'talleres' => $talleres,
                'userId' => $user->id,
            ]);
        } else {
            $talleres = $user->talleresAsignados()->withCount('secciones')->get();
            return view('talleres.index', [
                'talleres' => $talleres,
                'userId' => $user->id,
            ]);
        }
    }

    public function create()
    {
        // Verificación simple del rol
        if (auth()->user()->role !== 'administrador') {
            abort(403, 'Esta acción no está autorizada');
        }

        return view('talleres.create');
    }


    public function store(Request $request)
    {
        if (auth()->user()->role !== 'administrador') {
            abort(403, 'Esta acción no está autorizada');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Taller::create($validated);

        return redirect()->route('talleres.index')
            ->with('success', 'Taller creado exitosamente');
    }

    public function edit(Taller $taller)
    {
        if (auth()->user()->role !== 'administrador') {
            abort(403, 'Esta acción no está autorizada');
        }

        return view('talleres.edit', compact('taller'));
    }


    public function update(Request $request, Taller $taller)
    {
        if (auth()->user()->role !== 'administrador') {
            abort(403, 'Esta acción no está autorizada');
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $taller->update($validated);

        return redirect()->route('talleres.index')
            ->with('success', 'Taller actualizado exitosamente');
    }


    public function asignar()
    {
        $talleres = Taller::all();
        $users = User::where('role', 'docente')->get();

        return view('talleres.asignar', compact('talleres', 'users'));
    }


    public function storeAsignacion(Request $request)
    {
        //$this->authorize('asignar', Taller::class);

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

    public function show($id)
    {
        $taller = Taller::with(['usuariosAsignados' => function($query) {
            $query->select('users.id', 'users.name', 'users.email', 'users.role');
        }])->findOrFail($id);

        // Obtener usuarios no asignados (asegurando que siempre sea una colección)
        $usuariosNoAsignados = User::whereDoesntHave('talleresAsignados', function($query) use ($id) {
            $query->where('taller_id', $id);
        })->get() ?? collect(); // Usamos collect() para crear colección vacía si es null

        return view('talleres.show', compact('taller', 'usuariosNoAsignados'));
    }
    public function destroy(Taller $taller)
    {
        if (auth()->user()->role !== 'administrador') {
            abort(403, 'Esta acción no está autorizada');
        }

        $taller->delete();

        return redirect()->route('talleres.index')->with('success', 'Taller eliminado correctamente');
    }
    public function destroyAsignacion(Taller $taller, User $usuario)
    {
        $taller->usuariosAsignados()->detach($usuario->id);

        return back()->with('success', 'Usuario removido del taller correctamente');
    }

}
