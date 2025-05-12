<?php

namespace App\Http\Controllers;

use App\Models\SeccionTaller;
use App\Models\Taller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SeccionTallerController extends Controller
{
    public function create(Taller $taller)
    {
        return view('secciones.create', compact('taller'));
    }

    public function store(Request $request, Taller $taller)
    {
        // Depuración: Registrar los datos recibidos
        Log::info('Datos recibidos en SeccionTallerController@store', $request->all());

        $rules = [
            'tipo' => 'required|in:lectura,actividad,test',
            'titulo' => 'required|string|max:255',
        ];

        if ($request->tipo === 'lectura' || $request->tipo === 'actividad') {
            $rules['contenido'] = 'nullable|string'; // Cambiado a nullable
        } elseif ($request->tipo === 'test') {
            $rules['preguntas'] = 'required|array';
            $rules['preguntas.*.contenido'] = 'required|string';
            $rules['preguntas.*.opciones'] = 'required|array|size:2';
            $rules['preguntas.*.opciones.*'] = 'required|string';
            $rules['preguntas.*.respuesta_correcta'] = 'required|integer|min:0|max:1';
        }

        try {
            $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Errores de validación en SeccionTallerController@store', [
                'errors' => $e->errors(),
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        DB::beginTransaction();

        try {
            $seccion = new SeccionTaller();
            $seccion->taller_id = $taller->id;
            $seccion->tipo = $request->tipo;
            $seccion->titulo = $request->titulo;

            if ($request->tipo === 'test') {
                $preguntas = [];
                $respuestas_correctas = [];
                foreach ($request->preguntas as $index => $pregunta) {
                    $preguntas[] = [
                        'contenido' => $pregunta['contenido'],
                        'opciones' => $pregunta['opciones'],
                        'respuesta_correcta' => $pregunta['opciones'][$pregunta['respuesta_correcta']] ?? null,
                    ];
                    $respuestas_correctas[] = $pregunta['opciones'][$pregunta['respuesta_correcta']] ?? null;
                }
                $seccion->contenido = json_encode(array_column($preguntas, 'contenido'));
                $seccion->opciones = json_encode($preguntas);
                $seccion->respuesta_correcta = json_encode($respuestas_correctas);
            } else {
                $seccion->contenido = $request->contenido ?: null; // Asegurar que se guarde null si está vacío
                $seccion->opciones = null;
                $seccion->respuesta_correcta = null;
            }

            $seccion->save();

            DB::commit();

            Log::info('Sección guardada correctamente', [
                'seccion_id' => $seccion->id,
                'tipo' => $seccion->tipo,
                'titulo' => $seccion->titulo,
                'contenido' => $seccion->contenido,
            ]);

            return redirect()->route('talleres.edit', $taller)->with('success', 'Sección agregada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar la sección en SeccionTallerController@store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->withErrors(['error' => 'Error al guardar la sección: ' . $e->getMessage()])->withInput();
        }
    }

    public function edit($id)
    {
        $seccion = SeccionTaller::findOrFail($id);
        return view('secciones.edit', compact('seccion'));
    }

    public function update(Request $request, $id)
    {
        Log::info('Datos recibidos en SeccionTallerController@update', $request->all());

        $rules = [
            'tipo' => 'required|in:lectura,actividad,test',
            'titulo' => 'required|string|max:255',
        ];

        if ($request->tipo === 'lectura' || $request->tipo === 'actividad') {
            $rules['contenido'] = 'nullable|string';
        } elseif ($request->tipo === 'test') {
            $rules['preguntas'] = 'required|array';
            $rules['preguntas.*.contenido'] = 'required|string';
            $rules['preguntas.*.opciones'] = 'required|array|size:2';
            $rules['preguntas.*.opciones.*'] = 'required|string';
            $rules['preguntas.*.respuesta_correcta'] = 'required|integer|min:0|max:1';
        }

        try {
            $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Errores de validación en SeccionTallerController@update', [
                'errors' => $e->errors(),
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        DB::beginTransaction();

        try {
            $seccion = SeccionTaller::findOrFail($id);
            $seccion->tipo = $request->tipo;
            $seccion->titulo = $request->titulo;

            if ($request->tipo === 'test') {
                $preguntas = [];
                $respuestas_correctas = [];
                foreach ($request->preguntas as $index => $pregunta) {
                    $preguntas[] = [
                        'contenido' => $pregunta['contenido'],
                        'opciones' => $pregunta['opciones'],
                        'respuesta_correcta' => $pregunta['opciones'][$pregunta['respuesta_correcta']] ?? null,
                    ];
                    $respuestas_correctas[] = $pregunta['opciones'][$pregunta['respuesta_correcta']] ?? null;
                }
                $seccion->contenido = json_encode(array_column($preguntas, 'contenido'));
                $seccion->opciones = json_encode($preguntas);
                $seccion->respuesta_correcta = json_encode($respuestas_correctas);
            } else {
                $seccion->contenido = $request->contenido ?: null;
                $seccion->opciones = null;
                $seccion->respuesta_correcta = null;
            }

            $seccion->save();

            DB::commit();

            Log::info('Sección actualizada correctamente', [
                'seccion_id' => $seccion->id,
                'tipo' => $seccion->tipo,
                'titulo' => $seccion->titulo,
                'contenido' => $seccion->contenido,
            ]);

            return redirect()->route('talleres.edit', $seccion->taller_id)->with('success', 'Sección actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar la sección en SeccionTallerController@update', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->withErrors(['error' => 'Error al actualizar la sección: ' . $e->getMessage()])->withInput();
        }
    }
}
