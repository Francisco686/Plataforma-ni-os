<?php

namespace App\Http\Controllers;

use App\Models\{SesionActividad, Taller, User, Actividad, ActividadEstudiante};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

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

    public function ActividadesIndex($tallerId = null)
    {
        $user = auth()->user();

        // Depuración: Mostrar el tallerId recibido
        \Log::debug("ActividadesIndex - tallerId recibido: " . ($tallerId ?? 'null'));

        $query = SesionActividad::with(['actividades' => function($query) use ($user) {
            // ... (tu código existente)
        }])->with('docente');

        if ($tallerId) {
            $query->whereHas('actividades', function($q) use ($tallerId) {
                $q->where('taller_id', $tallerId);
            });
        }

        $sesiones = $query->get();

        // Depuración: Verificar las sesiones obtenidas
        \Log::debug("Sesiones encontradas: " . $sesiones->count());
        foreach($sesiones as $sesion) {
            \Log::debug("Sesión ID: {$sesion->id} - Actividades: " . $sesion->actividades->count());
        }

        $nombreTaller = '';
        if ($tallerId) {
            $taller = Taller::find($tallerId);
            $nombreTaller = $taller ? $taller->nombre : '';

            // Depuración: Verificar el taller encontrado
            \Log::debug("Taller encontrado: " . ($taller ? $taller->nombre : 'No encontrado'));
        }

        return view('actividades.actividades', [
            'sesiones' => $sesiones,
            'tallerSeleccionado' => $nombreTaller,
            'taller_id' => $tallerId // Asegúrate de pasar ambos
        ]);
    }
    public function show($sesion, $actividad = null, Request $request)
    {
        // Depuración: Mostrar parámetros recibidos
        \Log::debug("Show - Parámetros recibidos:", [
            'sesion' => $sesion,
            'actividad' => $actividad,
            'taller_id' => $request->taller_id
        ]);

        // Cargar solo las relaciones existentes
        $sesion = SesionActividad::with(['actividades', 'docente'])
            ->findOrFail($sesion);

        // Obtener taller_id solo del request o de la primera actividad
        $tallerId = $request->taller_id
            ?? optional($sesion->actividades->first())->taller_id;

        // Depuración: Mostrar el origen del taller_id
        \Log::debug("Origen del taller_id:", [
            'from_request' => $request->taller_id,
            'from_actividad' => optional($sesion->actividades->first())->taller_id,
            'final_value' => $tallerId
        ]);

        if ($actividad) {
            $actividad = $sesion->actividades->find($actividad);

            if (!$actividad) {
                abort(404, 'La actividad solicitada no existe');
            }

            // Depuración: Verificar actividad
            \Log::debug("Actividad encontrada:", [
                'id' => $actividad->id,
                'tipo' => $actividad->tipo,
                'taller_id' => $actividad->taller_id
            ]);

            // Procesar opciones para actividades
            if (in_array($actividad->tipo, ['opcion_multiple', 'verdadero_falso'])) {
                $actividad->opciones = $this->procesarOpciones($actividad);
            }
        }

        return view('actividades.show', [
            'sesion' => $sesion,
            'actividad' => $actividad,
            'taller_id' => $tallerId,
            'tallerSeleccionado' => $tallerId // Solo pasamos el ID ya que no tenemos modelo Taller
        ]);
    }


    public function Create()
    {
        return view('actividades.create');
    }

    public function Store(Request $request)
    {
        // Depuración inicial de los datos recibidos
        \Log::debug('================ INICIO STORE ================');
        \Log::debug('Datos completos recibidos:', $request->all());
        \Log::debug('Datos de actividades recibidos:', ['actividades' => $request->input('actividades')]);

        // Validación de datos
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'taller_id' => 'required|numeric',
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
                    $opciones = $request->input("actividades.$index.opciones", []);

                    \Log::debug("Validando respuesta correcta para actividad $index", [
                        'tipo' => $tipo,
                        'valor' => $value,
                        'opciones' => $opciones
                    ]);

                    if (in_array($tipo, ['opcion_multiple', 'verdadero_falso']) && $value === null) {
                        $fail('La respuesta correcta es requerida para este tipo de actividad.');
                        return;
                    }

                    if ($tipo === 'verdadero_falso' && !in_array(strtolower($value), ['verdadero', 'falso'])) {
                        $fail('Para verdadero/falso, la respuesta debe ser "Verdadero" o "Falso".');
                        return;
                    }

                    if ($tipo === 'opcion_multiple') {
                        if (!is_numeric($value)) {
                            $fail('El índice de respuesta correcta debe ser numérico.');
                            return;
                        }

                        if (!array_key_exists($value, $opciones)) {
                            $fail('La respuesta correcta debe ser una de las opciones proporcionadas.');
                            return;
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

                    \Log::debug("Validando opciones para actividad $index", [
                        'tipo' => $tipo,
                        'opciones' => $value
                    ]);

                    if ($tipo === 'opcion_multiple') {
                        if (empty($value)) {
                            $fail('Debe proporcionar opciones para preguntas de opción múltiple.');
                            return;
                        }

                        if (count($value) < 2) {
                            $fail('Debe proporcionar al menos 2 opciones.');
                            return;
                        }

                        foreach ($value as $i => $opcion) {
                            if (empty(trim($opcion))) {
                                $fail("La opción #" . ($i + 1) . " no puede estar vacía.");
                                return;
                            }
                        }
                    }
                }
            ],
            'actividades.*.opciones.*' => 'required|string|min:1',
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

        \Log::debug('Datos validados correctamente:', $validated);

        try {
            // Crear la sesión
            $sesion = SesionActividad::create([
                'taller_id' => $validated['taller_id'],
                'docente_id' => auth()->id(),
                'titulo' => $validated['titulo'],
                'descripcion' => $validated['descripcion'],
                'fecha_limite' => $validated['fecha_limite'] ?? null,
            ]);

            \Log::debug('Sesión creada:', $sesion->toArray());

            // Procesar cada actividad
            foreach ($validated['actividades'] as $index => $actividadData) {
                \Log::debug("Procesando actividad #$index", $actividadData);

                $actividadData['taller_id'] = $validated['taller_id'];
                $actividad = $this->createActivity($sesion, $actividadData);

                \Log::debug("Actividad #$index creada:", [
                    'id' => $actividad->id,
                    'tipo' => $actividad->tipo,
                    'pregunta' => $actividad->pregunta,
                    'opciones' => $actividad->opciones ? json_decode($actividad->opciones, true) : null,
                    'respuesta_correcta' => $actividad->respuesta_correcta
                ]);
            }

            \Log::debug('================ FIN STORE EXITOSO ================');
            return redirect()->route('actividades.index')
                ->with('success', 'Sesión creada correctamente');

        } catch (\Exception $e) {
            \Log::error('ERROR en Store:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            \Log::debug('================ FIN STORE CON ERROR ================');
            return back()->withInput()->withErrors([
                'error' => 'Error al crear la sesión: ' . $e->getMessage()
            ]);
        }
    }

    protected function createActivity($sesion, $data)
    {
        \Log::debug('Creando actividad con datos:', $data);

        $archivoPath = null;
        if (isset($data['archivo_referencia']) && $data['archivo_referencia'] instanceof \Illuminate\Http\UploadedFile) {
            $archivoPath = $data['archivo_referencia']->store('actividades/referencias');
            \Log::debug('Archivo guardado en:', ['path' => $archivoPath]);
        }

        $actividadData = [
            'taller_id' => $data['taller_id'],
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
                $actividadData['respuesta_correcta'] = isset($data['respuesta_correcta']) ?
                    strtolower($data['respuesta_correcta']) : null;
                $actividadData['opciones'] = json_encode(['Verdadero', 'Falso']);
                break;

            case 'opcion_multiple':
                $actividadData['pregunta'] = $data['pregunta'] ?? null;
                $opciones = $data['opciones'] ?? [];

                // Validar y normalizar respuesta correcta
                $respuestaCorrecta = $data['respuesta_correcta'] ?? 0;
                if (!is_numeric($respuestaCorrecta) || !array_key_exists($respuestaCorrecta, $opciones)) {
                    \Log::warning('Respuesta correcta inválida, usando primera opción por defecto', [
                        'respuesta_provista' => $data['respuesta_correcta'],
                        'opciones_disponibles' => $opciones
                    ]);
                    $respuestaCorrecta = 0;
                }

                $actividadData['respuesta_correcta'] = $respuestaCorrecta;
                $actividadData['opciones'] = json_encode(array_values($opciones));

                \Log::debug('Opciones múltiples procesadas:', [
                    'opciones' => $opciones,
                    'respuesta_correcta' => $respuestaCorrecta,
                    'opciones_json' => $actividadData['opciones']
                ]);
                break;

            case 'video':
                $actividadData['pregunta'] = $data['pregunta'] ?? null;
                $actividadData['video_url'] = !empty($data['video_url']) ? $this->parseVideoUrl($data['video_url']) : null;
                break;

            case 'archivo':
                break;
        }

        $actividad = $sesion->actividades()->create($actividadData);
        \Log::debug('Actividad creada:', $actividad->toArray());

        return $actividad;
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



    protected function procesarOpciones($actividad)
    {
        if ($actividad->tipo === 'opcion_multiple' && $actividad->opciones) {
            try {
                return json_decode($actividad->opciones, true) ?: [];
            } catch (\Exception $e) {
                return [];
            }
        }

        if ($actividad->tipo === 'verdadero_falso') {
            return ['Verdadero', 'Falso'];
        }

        return [];
    }
    public function responderStore(Request $request, $sesionId)
    {
        // Validación de los datos del formulario
        $validated = $request->validate([
            'respuestas' => 'required|array',
            'respuestas.*.tipo' => 'required|string',
            'respuestas.*.respuesta' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    $parts = explode('.', $attribute);
                    $index = $parts[1];
                    $tipo = $request->input("respuestas.$index.tipo");

                    if ($tipo === 'verdadero_falso' && !in_array(strtolower($value), ['verdadero', 'falso'])) {
                        $fail('La respuesta para verdadero/falso debe ser "Verdadero" o "Falso".');
                    }

                    if ($tipo === 'opcion_multiple' && !is_numeric($value)) {
                        $fail('La respuesta para opción múltiple debe ser un índice válido.');
                    }
                }
            ],
            'respuestas.*.archivo' => 'nullable|file|max:10240',
            'taller_id' => 'required|numeric' // Validación simplificada
        ]);

        // Obtener la sesión con sus actividades
        $sesion = SesionActividad::with('actividades')->findOrFail($sesionId);

        // Obtener el taller_id de la primera actividad (solución clave)
        $tallerIdReal = $sesion->actividades->first()->taller_id ?? null;

        // Verificar coincidencia del taller_id
        if ($validated['taller_id'] != $tallerIdReal) {
            return back()->with('error', 'El taller no coincide con las actividades de la sesión');
        }

        $totalActividades = $sesion->actividades->count();
        $completadas = 0;

        DB::beginTransaction();
        try {
            foreach ($validated['respuestas'] as $actividadId => $respuestaData) {
                $actividad = $sesion->actividades->find($actividadId);
                if (!$actividad) continue;

                $archivoPath = null;
                $respuestaTexto = null;
                $estado = 'pendiente';

                switch ($actividad->tipo) {
                    case 'texto':
                        $respuestaTexto = 'Texto leído';
                        $estado = 'completada';
                        break;

                    case 'pregunta':
                        $respuestaTexto = $respuestaData['respuesta'] ?? null;
                        $estado = !empty($respuestaTexto) ? 'completada' : 'pendiente';
                        break;

                    case 'opcion_multiple':
                        if (isset($respuestaData['respuesta']) && is_numeric($respuestaData['respuesta'])) {
                            $opciones = json_decode($actividad->opciones, true) ?? [];
                            $indiceRespuesta = (int)$respuestaData['respuesta'];
                            $respuestaTexto = $opciones[$indiceRespuesta] ?? null;
                            $estado = $respuestaTexto ? 'completada' : 'pendiente';
                        }
                        break;

                    case 'verdadero_falso':
                        if (isset($respuestaData['respuesta']) && in_array(strtolower($respuestaData['respuesta']), ['verdadero', 'falso'])) {
                            $respuestaTexto = ucfirst(strtolower($respuestaData['respuesta']));
                            $estado = 'completada';
                        }
                        break;

                    case 'video':
                        $respuestaTexto = 'Video visto';
                        $estado = 'completada';
                        break;

                    case 'archivo':
                        if ($request->hasFile("respuestas.$actividadId.archivo")) {
                            $archivoPath = $request->file("respuestas.$actividadId.archivo")
                                ->store("respuestas/alumno_" . auth()->id());
                            $estado = 'completada';
                        }
                        break;
                }

                // Manejo adicional para actividades que permiten archivos
                if ($actividad->permite_archivo && $request->hasFile("respuestas.$actividadId.archivo")) {
                    $archivoPath = $request->file("respuestas.$actividadId.archivo")
                        ->store("respuestas/alumno_" . auth()->id());
                    $estado = 'completada';
                }

                // Guardar o actualizar el registro de la actividad del estudiante
                $registro = ActividadEstudiante::updateOrCreate(
                    [
                        'actividad_id' => $actividadId,
                        'estudiante_id' => auth()->id(),
                    ],
                    [
                        'estado' => $estado,
                        'respuesta' => $respuestaTexto,
                        'archivo_path' => $archivoPath,
                        'taller_id' => $tallerIdReal,
                        'docente_id' => $sesion->docente_id,
                        'fecha_completado' => $estado === 'completada' ? now() : null,
                        'fecha_inicio' => DB::raw('IFNULL(fecha_inicio, NOW())')
                    ]
                );

                if ($registro->estado === 'completada') {
                    $completadas++;
                }
            }

            // Actualizar estado general de la sesión
            $estadoGeneral = match(true) {
                $completadas === $totalActividades => 'completada',
                $completadas > 0 => 'en_progreso',
                default => 'pendiente'
            };

            $sesion->update(['estado' => $estadoGeneral]);

            DB::commit();

            return redirect()->route('actividades.index', ['taller_id' => $tallerIdReal])
                ->with('success', 'Respuestas enviadas correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al guardar las respuestas: ' . $e->getMessage());
        }
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

            return redirect()->route('actividades.index')
                ->with('success', 'Sesión eliminada correctamente');

        } catch (\Exception $e) {
            Log::error('Error al eliminar sesión: ' . $e->getMessage());
            return back()->with('error', 'Error al eliminar la sesión: ' . $e->getMessage());
        }
    }
    public function editSesion($id)
    {
        $sesion = Sesion::with('actividades')->findOrFail($id);
        return view('actividades.edit', compact('sesion'));
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
