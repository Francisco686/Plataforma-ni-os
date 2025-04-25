<?php

namespace App\Http\Controllers;

use App\Models\Taller;
use App\Models\User;
use App\Models\AsignaTaller;
use App\Models\ProgresoTaller;
use Illuminate\Http\Request;

class TallerController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if($user->role === 'administrador') {
            $talleres = Taller::withCount('secciones')->get();
            $usuarios = User::where('role', '!=', 'administrador')->get();

            return view('talleres.index', [
                'talleres' => $talleres,
                'userId' => $user->id,
                'usuarios' => $usuarios,
            ]);
        } else {
            $talleres = $user->talleresAsignados()->with('taller.secciones')->get()->map(function ($asignacion) {
                $taller = $asignacion->taller;
                $taller->asignacion = $asignacion;
                return $taller;
            });

            return view('talleres.index', [
                'talleres' => $talleres,
                'userId' => $user->id,
            ]);
        }
    }

    public function create()
    {
        if (auth()->user()->role !== 'administrador') {
            abort(403);
        }

        return view('talleres.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'administrador') {
            abort(403);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Taller::create($validated);

        return redirect()->route('talleres.index')->with('success', 'Taller creado exitosamente');
    }

    public function edit(Taller $taller)
    {
        if (auth()->user()->role !== 'administrador') {
            abort(403);
        }

        return view('talleres.edit', compact('taller'));
    }

    public function update(Request $request, Taller $taller)
    {
        if (auth()->user()->role !== 'administrador') {
            abort(403);
        }

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $taller->update($validated);

        return redirect()->route('talleres.index')->with('success', 'Taller actualizado exitosamente');
    }

    public function destroy(Taller $taller)
    {
        if (auth()->user()->role !== 'administrador') {
            abort(403);
        }

        $taller->delete();

        return redirect()->route('talleres.index')->with('success', 'Taller eliminado correctamente');
    }

    public function asignar()
    {
        $talleres = Taller::all();
        $users = User::where('role', 'docente')->get();

        return view('talleres.asignar', compact('talleres', 'users'));
    }

    public function storeAsignacion(Request $request)
    {
        $this->authorize('asignar', Taller::class);

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

    public function show(Taller $taller)
    {
        $user = auth()->user();
        $asignacion = null;

        if ($user->role !== 'administrador') {
            $asignacion = AsignaTaller::where('user_id', $user->id)
                ->where('taller_id', $taller->id)
                ->firstOrFail();
        }

        $secciones = $taller->secciones()->orderBy('orden')->get();

        $progreso = $asignacion
            ? $asignacion->progresos()->where('completado', true)->pluck('seccion_taller_id')->toArray()
            : [];

        return view('talleres.show', compact('taller', 'secciones', 'asignacion', 'progreso'));
    }

    public function completar(Request $request)
    {
        $request->validate([
            'asigna_taller_id' => 'required|exists:asigna_tallers,id',
            'seccion_taller_id' => 'required|exists:seccion_tallers,id',
        ]);

        ProgresoTaller::firstOrCreate([
            'asigna_taller_id' => $request->asigna_taller_id,
            'seccion_taller_id' => $request->seccion_taller_id,
        ], [
            'completado' => true,
        ]);

        return back()->with('success', 'Sección marcada como completada');
    }
}