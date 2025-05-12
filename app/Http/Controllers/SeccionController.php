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
            'titulo' => 'required|string|max:255', // ← valida el campo titulo
            'contenido' => 'nullable|string',
            'taller_id' => 'required|exists:tallers,id',
            'tipo' => 'required|in:lectura,actividad,test',
        ]);

        SeccionTaller::create([
            'titulo' => $request->titulo, // ← asigna el campo titulo
            'contenido' => $request->contenido,
            'taller_id' => $request->taller_id,
            'tipo' => $request->tipo,
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
