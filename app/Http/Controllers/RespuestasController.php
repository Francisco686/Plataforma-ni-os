<?php

namespace App\Http\Controllers;

use App\Models\SeccionTaller;
use App\Models\RespuestaAlumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RespuestasController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos enviados
        $request->validate([
            'seccion_id' => 'required|exists:secciones_taller,id',
            'respuesta' => 'required|array',
            'respuesta.*' => 'required|numeric|min:0|max:1', // Cambiado de integer a numeric
        ]);

        // Obtener la sección
        $seccion = SeccionTaller::findOrFail($request->seccion_id);
        $opciones = json_decode($seccion->opciones ?? '[]', true); // Compatible con JSON
        $respuestas_correctas = json_decode($seccion->respuesta_correcta ?? '[]', true);

        // Depuración: Registrar los datos recibidos
        Log::debug('Datos recibidos en RespuestasController@store', [
            'request' => $request->all(),
            'opciones' => $opciones,
            'respuestas_correctas' => $respuestas_correctas,
        ]);

        foreach ($request->respuesta as $preguntaIndex => $opcionIndex) {
            // Convertir $opcionIndex a entero
            $opcionIndex = (int) $opcionIndex;

            if (!isset($opciones[$preguntaIndex]) || !isset($opciones[$preguntaIndex]['opciones']) || !is_array($opciones[$preguntaIndex]['opciones'])) {
                Log::warning('Pregunta o opciones no válidas', [
                    'pregunta_index' => $preguntaIndex,
                    'opciones' => $opciones[$preguntaIndex] ?? 'No definido',
                ]);
                continue;
            }

            if (!isset($opciones[$preguntaIndex]['opciones'][$opcionIndex])) {
                Log::warning('Índice de opción inválido', [
                    'pregunta_index' => $preguntaIndex,
                    'opcion_index' => $opcionIndex,
                    'opciones_disponibles' => $opciones[$preguntaIndex]['opciones'],
                ]);
                continue;
            }

            $respuestaTexto = $opciones[$preguntaIndex]['opciones'][$opcionIndex];
            $esCorrecta = $respuestaTexto === ($respuestas_correctas[$preguntaIndex] ?? null);

            try {
                RespuestaAlumno::create([
                    'user_id' => Auth::id(),
                    'seccion_id' => $seccion->id,
                    'pregunta_index' => (int) $preguntaIndex,
                    'respuesta' => $respuestaTexto,
                    'es_correcta' => $esCorrecta,
                ]);

                Log::info('Respuesta guardada', [
                    'pregunta_index' => $preguntaIndex,
                    'respuesta_texto' => $respuestaTexto,
                    'es_correcta' => $esCorrecta,
                ]);
            } catch (\Exception $e) {
                Log::error('Error al guardar la respuesta', [
                    'pregunta_index' => $preguntaIndex,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        return redirect()->route('talleres.show', $seccion->taller_id)->with('success', 'Respuestas enviadas correctamente.');
    }
}
