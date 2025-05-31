<?php

namespace App\Http\Controllers;

use App\Models\{SesionActividad, Taller, User, Actividad, ActividadEstudiante};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ActividadController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'administrador') {
            $talleres = Taller::with([
                'usuariosAsignados',
                'secciones',
                'secciones.sesiones.actividades' => function($query) use ($user) {
                    $query->with([
                        'respuestasAlumno' => function($q) use ($user) {
                            $q->where('estudiante_id', $user->id);
                        }
                    ]);
                }
            ])->withCount('secciones')->get();

            return view('talleres.index', [
                'talleres' => $talleres,
                'userId' => $user->id,
            ]);
        }

        $talleres = Taller::with([
            'secciones.sesiones.actividades' => function($query) use ($user) {
                $query->with([
                    'respuestasAlumno' => function($q) use ($user) {
                        $q->where('estudiante_id', $user->id);
                    }
                ]);
            }
        ])->get();
        $sesiones = SesionActividad::with(['actividades.respuestasAlumno' => function ($q) {
            $q->where('estudiante_id', auth()->id());
        }, 'docente'])->get();


        return view('actividades.index', compact('talleres','sesiones'));
    }

    public function reutilizarIndex()
    {
        $query = SesionActividad::with(['actividades', 'docente']);

        if (auth()->user()->isDocente()) {
            $query->where('docente_id', auth()->id());
        }

        $sesiones = $query->latest()->get();

        return view('actividades.reutilizar.index', compact('sesiones'));
    }

    public function reutilizarCreate()
    {
        return view('actividades.reutilizar.create');
    }

    public function reutilizarStore(Request $request)
    {
        \Log::debug('Datos recibidos:', $request->all());
        \Log::debug('Actividades recibidas:', $request->input('actividades'));

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'fecha_limite' => 'nullable|date',
            'actividades' => 'required|array|min:1',
            'actividades.*.tipo' => 'required|string|in:texto,pregunta,opcion_multiple,verdadero_falso,video,archivo',
            'actividades.*.pregunta' => 'nullable|string|required_if:actividades.*.tipo,pregunta,opcion_multiple,verdadero_falso,video',
            'actividades.*.contenido' => 'nullable|string|required_if:actividades.*.tipo,texto',
            'actividades.*.respuesta_correcta' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];
                    $tipo = $request->input("actividades.$index.tipo");

                    // Solo requerido para opción múltiple y verdadero/falso
                    if (in_array($tipo, ['opcion_multiple', 'verdadero_falso']) && empty($value)) {
                        $fail('La respuesta correcta es requerida para este tipo de actividad.');
                    }

                    // Validaciones específicas para verdadero/falso
                    if ($tipo === 'verdadero_falso' && !empty($value) &&
                        !in_array(strtolower($value), ['verdadero', 'falso'])) {
                        $fail('Para verdadero/falso, la respuesta debe ser "Verdadero" o "Falso".');
                    }

                    // Validación para opción múltiple
                    if ($tipo === 'opcion_multiple' && !empty($value)) {
                        $opciones = $request->input("actividades.$index.opciones", []);
                        if (!array_key_exists($value, $opciones)) {
                            $fail('La respuesta correcta debe ser una de las opciones proporcionadas.');
                        }
                    }
                }
            ],
            'actividades.*.opciones' => [
                'nullable',
                'array',
                function ($attribute, $value, $fail) use ($request) {
                    $index = explode('.', $attribute)[1];
                    $tipo = $request->input("actividades.$index.tipo");

                    // Solo requerido para opción múltiple
                    if ($tipo === 'opcion_multiple' && empty($value)) {
                        $fail('Debe proporcionar opciones para preguntas de opción múltiple.');
                    }

                    // Para verdadero/falso, establecer las opciones automáticamente
                    if ($tipo === 'verdadero_falso') {
                        return ['Verdadero', 'Falso'];
                    }
                }
            ],
            'actividades.*.opciones.*' => 'nullable|string',
            'actividades.*.video_url' => [
                'nullable',
                'required_if:actividades.*.tipo,video',
                function ($attribute, $value, $fail) {
                    if (!empty($value) && !preg_match('/youtube\.com|vimeo\.com/', $value)) {
                        $fail('Solo se permiten URLs de YouTube o Vimeo.');
                    }
                }
            ],
            'actividades.*.archivo_referencia' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:10240',
            'actividades.*.permite_archivo' => 'nullable|boolean',
            'actividades.*.puntos' => 'nullable|integer|min:1',
        ]);

        try {
            $sesion = SesionActividad::create([
                'docente_id' => auth()->id(),
                'titulo' => $validated['titulo'],
                'descripcion' => $validated['descripcion'],
                'fecha_limite' => $validated['fecha_limite'] ?? null,
            ]);

            \Log::debug('Sesión creada:', $sesion->toArray());

            foreach ($validated['actividades'] as $actividadData) {
                $actividad = $this->createActivity($sesion, $actividadData);
                \Log::debug('Actividad creada:', $actividad->toArray());
            }

            return redirect()->route('actividades.reutilizar.index')
                ->with('success', 'Sesión creada correctamente');
        } catch (\Exception $e) {
            \Log::error('Error al crear sesión: ' . $e->getMessage());
            return back()->withInput()->withErrors([
                'error' => 'Error al crear la sesión: ' . $e->getMessage()
            ]);
        }

    }

    protected function createActivity($sesion, $data)
    {
        $archivoPath = null;
        if (isset($data['archivo_referencia']) && $data['archivo_referencia'] instanceof \Illuminate\Http\UploadedFile) {
            $archivoPath = $data['archivo_referencia']->store('actividades/referencias');
        }

        $actividadData = [
            'tipo' => $data['tipo'],
            'puntos' => $data['puntos'] ?? 1,
            'archivo_path' => $archivoPath,
            'permite_archivo' => $data['permite_archivo'] ?? false,
            'contenido' => null,
        ];

        switch ($data['tipo']) {
            case 'texto':
                $actividadData['contenido'] = $data['contenido'] ?? null;
                break;

            case 'pregunta':
                $actividadData['pregunta'] = $data['pregunta'] ?? null;
                break;

            case 'verdadero_falso':
                $actividadData['pregunta'] = $data['pregunta'] ?? null;
                $actividadData['respuesta_correcta'] = isset($data['respuesta_correcta']) ? strtolower($data['respuesta_correcta']) : null;
                $actividadData['opciones'] = json_encode(['Verdadero', 'Falso']);
                break;

            case 'opcion_multiple':
                $actividadData['pregunta'] = $data['pregunta'] ?? null;
                $actividadData['respuesta_correcta'] = $data['respuesta_correcta'] ?? null;
                $actividadData['opciones'] = isset($data['opciones']) ? json_encode(array_values($data['opciones'])) : null;
                break;

            case 'video':
                $actividadData['pregunta'] = $data['pregunta'] ?? null;
                $actividadData['video_url'] = !empty($data['video_url']) ? $this->parseVideoUrl($data['video_url']) : null;
                break;

            case 'archivo':
                // No additional fields needed for this type
                break;
        }

        return $sesion->actividades()->create($actividadData);
    }

    protected function parseVideoUrl($url)
    {
        if (str_contains($url, 'youtube.com/watch?v=')) {
            return str_replace('watch?v=', 'embed/', $url);
        }
        if (str_contains($url, 'vimeo.com/')) {
            return preg_replace('/vimeo.com\/(\d+)/', 'player.vimeo.com/video/$1', $url);
        }
        return $url;
    }

    public function show($sesion, $actividad = null)
    {
        $sesion = SesionActividad::with(['actividades', 'docente'])
            ->findOrFail($sesion);

        if ($actividad) {
            $actividad = $sesion->actividades->find($actividad);

            if (!$actividad) {
                abort(404, 'La actividad solicitada no existe');
            }

            // Procesar opciones para actividades de opción múltiple
            if ($actividad->tipo === 'opcion_multiple' && $actividad->opciones) {
                try {
                    $actividad->opciones = json_decode($actividad->opciones, true);
                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $actividad->opciones = [];
                    }
                } catch (\Exception $e) {
                    $actividad->opciones = [];
                }
            }

            // Establecer opciones fijas para verdadero/falso
            if ($actividad->tipo === 'verdadero_falso') {
                $actividad->opciones = ['Verdadero', 'Falso'];
            }

            return view('actividades.reutilizar.show', compact('sesion', 'actividad'));
        }

        return view('actividades.reutilizar.show', compact('sesion'));
    }
    public function responderStore(Request $request, $sesionId)
    {
        $request->validate([
            'respuestas' => 'required|array',
            'respuestas.*.tipo' => 'required|string',
            'respuestas.*.respuesta' => 'nullable|string',
            'respuestas.*.archivo' => 'nullable|file|max:10240',
        ]);

        $sesion = SesionActividad::with('actividades')->findOrFail($sesionId);
        $totalActividades = $sesion->actividades->count();
        $completadas = 0;

        foreach ($request->respuestas as $actividadId => $respuestaData) {
            $actividad = $sesion->actividades->find($actividadId);
            $archivoPath = null;

            if (isset($respuestaData['archivo']) && $respuestaData['archivo'] instanceof \Illuminate\Http\UploadedFile) {
                $archivoPath = $respuestaData['archivo']->store('respuestas/alumno_' . auth()->id());
            }

            // Determinar si la actividad es de solo texto y debe marcarse como completada automáticamente
            $esSoloTexto = $actividad->tipo === 'texto' && empty($respuestaData['respuesta']) && empty($archivoPath);
            $estado = $esSoloTexto ? 'completada' :
                (!empty($respuestaData['respuesta']) || !empty($archivoPath) ? 'completada' : 'pendiente');

            $registro = ActividadEstudiante::updateOrCreate(
                [
                    'actividad_id' => $actividadId,
                    'estudiante_id' => auth()->id(),
                ],
                [
                    'estado' => $estado,
                    'respuesta' => $respuestaData['respuesta'] ?? ($esSoloTexto ? 'Texto leído' : null),
                    'archivo_path' => $archivoPath,
                    'taller_id' => $sesion->id,
                    'docente_id' => $sesion->docente_id,
                    'fecha_completado' => $estado === 'completada' ? now() : null,
                ]
            );

            if (is_null($registro->fecha_inicio)) {
                $registro->update(['fecha_inicio' => now()]);
            }

            if ($registro->estado === 'completada') {
                $completadas++;
            }
        }

        // Actualizar estado general de la sesión
        $estadoGeneral = 'pendiente';
        if ($completadas > 0 && $completadas < $totalActividades) {
            $estadoGeneral = 'en_progreso';
        } elseif ($completadas === $totalActividades) {
            $estadoGeneral = 'completada';
        }

        $sesion->update(['estado' => $estadoGeneral]);

        return redirect()->route('actividades.reutilizar.index')
            ->with('success', 'Respuestas enviadas correctamente');
    }

    public function destroy($sesionId)
    {
        try {
            $sesion = SesionActividad::where('docente_id', auth()->id())
                ->with(['actividades.respuestasEstudiantes'])
                ->findOrFail($sesionId);

            // Verificar si hay actividades antes de intentar eliminarlas
            if ($sesion->actividades->isNotEmpty()) {
                foreach ($sesion->actividades as $actividad) {
                    // Eliminar archivos asociados a la actividad
                    if ($actividad->archivo_path && Storage::exists($actividad->archivo_path)) {
                        Storage::delete($actividad->archivo_path);
                    }

                    // Verificar si hay respuestas antes de intentar eliminarlas
                    if ($actividad->respuestasEstudiantes->isNotEmpty()) {
                        foreach ($actividad->respuestasEstudiantes as $respuesta) {
                            if ($respuesta->archivo_path && Storage::exists($respuesta->archivo_path)) {
                                Storage::delete($respuesta->archivo_path);
                            }
                            $respuesta->delete();
                        }
                    }

                    $actividad->delete();
                }
            }

            $sesion->delete();

            return redirect()->route('actividades.reutilizar.index')
                ->with('success', 'Sesión eliminada correctamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar sesión: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la sesión: ' . $e->getMessage());
        }
    }
    public function editSesion($id)
    {
        $sesion = Sesion::with('actividades')->findOrFail($id);
        return view('actividades.reutilizar.edit', compact('sesion'));
    }

    public function destroySesion($id)
    {
        $sesion = Sesion::findOrFail($id);

        // Elimina las actividades relacionadas primero si hay dependencia
        foreach ($sesion->actividades as $actividad) {
            $actividad->delete();
        }

        $sesion->delete();

        return redirect()->route('actividades.index')->with('success', 'Sesión eliminada correctamente.');
    }

}
