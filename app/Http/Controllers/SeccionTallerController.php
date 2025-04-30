<?php

namespace App\Http\Controllers;

use App\Models\SeccionTaller;
use App\Models\Taller;
use Illuminate\Http\Request;

class SeccionTallerController extends Controller
{
    public function create(Taller $taller)
    {
        return view('secciones.create', compact('taller'));
    }

    public function store(Request $request, Taller $taller)
    {
        $request->validate([
            'tipo' => 'required|in:lectura,actividad,test',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'opciones' => 'nullable|array',
            'respuesta_correcta' => 'nullable'
        ]);

        $seccion = new SeccionTaller();
        $seccion->taller_id = $taller->id;
        $seccion->nombre = $request->nombre;
        $seccion->descripcion = $request->descripcion;
        $seccion->orden = $taller->secciones()->count() + 1;
        $seccion->tipo = $request->tipo;
        $seccion->contenido = $request->descripcion;

        if ($request->tipo === 'test') {
            $seccion->opciones = json_encode($request->opciones);
            $seccion->respuesta_correcta = $request->opciones[$request->respuesta_correcta] ?? null;
        }

        $seccion->save();

        return redirect()->route('talleres.edit', $taller)->with('success', 'Sección agregada correctamente.');
    }

    public function edit($id)
    {
        $seccion = SeccionTaller::findOrFail($id);
        return view('secciones.edit', compact('seccion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|in:lectura,actividad,test',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'opciones' => 'nullable|array',
            'respuesta_correcta' => 'nullable'
        ]);

        $seccion = SeccionTaller::findOrFail($id);
        $seccion->tipo = $request->tipo;
        $seccion->nombre = $request->nombre;
        $seccion->descripcion = $request->descripcion;
        $seccion->contenido = $request->descripcion;

        if ($request->tipo === 'test') {
            $seccion->opciones = json_encode($request->opciones);
            $seccion->respuesta_correcta = $request->opciones[$request->respuesta_correcta] ?? null;
        } else {
            $seccion->opciones = null;
            $seccion->respuesta_correcta = null;
        }

        $seccion->save();

        return redirect()->route('talleres.edit', $seccion->taller_id)->with('success', 'Sección actualizada correctamente.');
    }
}
