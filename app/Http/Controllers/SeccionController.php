<?php
namespace App\Http\Controllers;

use App\Models\Taller;
use App\Models\SeccionTaller;
use Illuminate\Http\Request;

class SeccionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden' => 'required|integer|min:1',
            'taller_id' => 'required|exists:tallers,id'
        ]);

        SeccionTaller::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden,
            'taller_id' => $request->taller_id
        ]);

        return redirect()->back()->with('success', 'Sección agregada correctamente');
    }

    public function edit(SeccionTaller $seccion)
    {
        return view('secciones.edit', compact('seccion'));
    }

    public function update(Request $request, SeccionTaller $seccion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'orden' => 'required|integer|min:1',
        ]);

        $seccion->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'orden' => $request->orden
        ]);

        return redirect()->route('talleres.ver', $seccion->taller_id)->with('success', 'Sección actualizada correctamente');
    }

    public function destroy(SeccionTaller $seccion)
    {
        $seccion->delete();
        return redirect()->back()->with('success', 'Sección eliminada correctamente');
    }
}
