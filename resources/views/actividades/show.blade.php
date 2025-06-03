@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('actividades.actividades', isset($taller_id) ? ['tallerId' => $taller_id] : [] ) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Volver
                    </a>
                    @if(auth()->user()->isDocente())
                        <span class="badge bg-primary">
                            <i class="fas fa-chalkboard-teacher me-1"></i> Vista de docente
                        </span>
                    @else
                        @php
                            $totalActividades = $sesion->actividades->count();
                            $completadas = $sesion->actividades->filter(function($actividad) {
                                return $actividad->respuestasAlumno->where('estudiante_id', auth()->id())->where('estado', 'completada')->count() > 0;
                            })->count();
                        @endphp
                        <span class="badge bg-{{ $completadas == $totalActividades ? 'success' : ($completadas > 0 ? 'warning' : 'secondary') }}">
                            {{ $completadas == $totalActividades ? 'Completada' : ($completadas > 0 ? 'En progreso' : 'Pendiente') }}
                        </span>
                    @endif
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">{{ $sesion->titulo }}</h4>
                        <small class="d-block">Creada por: {{ $sesion->docente->name }}</small>
                        @if($sesion->fecha_limite)
                            <small class="d-block">Fecha límite: {{ $sesion->fecha_limite->format('d/m/Y H:i') }}</small>
                        @endif
                    </div>

                    <div class="card-body">
                        @if($sesion->descripcion)
                            <div class="mb-4 p-3 bg-light rounded">
                                <h5 class="mb-2">Descripción:</h5>
                                <p class="mb-0">{{ $sesion->descripcion }}</p>
                            </div>
                        @endif

                        @if(auth()->user()->isAlumno())
                            <form action="{{ route('actividades.responder.store', $sesion->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @endif

                                @foreach($sesion->actividades as $index => $actividad)
                                    @php
                                        $respuestaAlumno = $actividad->respuestasAlumno->where('estudiante_id', auth()->id())->first();
                                        $completada = $respuestaAlumno && $respuestaAlumno->estado == 'completada';
                                    @endphp

                                    <div class="card mb-4 {{ $completada ? 'border-success' : '' }}">
                                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                            <h5 class="mb-0">
                                                Actividad #{{ $index + 1 }}: {{ ucfirst(str_replace('_', ' ', $actividad->tipo)) }}
                                                @if($completada)
                                                    <i class="fas fa-check-circle text-success ms-2"></i>
                                                @endif
                                            </h5>
                                            @if($actividad->puntos)
                                                <span class="badge bg-success">
                                            <i class="fas fa-star me-1"></i> {{ $actividad->puntos }} punto(s)
                                        </span>
                                            @endif
                                        </div>

                                        <div class="card-body">
                                            <!-- Contenido común -->
                                            @if($actividad->pregunta)
                                                <div class="mb-3">
                                                    <p class="fw-bold">{!! nl2br(e($actividad->pregunta)) !!}</p>
                                                </div>
                                            @endif

                                            @if($actividad->contenido)
                                                <div class="mb-3">
                                                    <div class="alert alert-light">{!! nl2br(e($actividad->contenido)) !!}</div>
                                                </div>
                                            @endif

                                            @if($actividad->archivo_path)
                                                <div class="mb-3">
                                                    <a href="{{ Storage::url($actividad->archivo_path) }}"
                                                       class="btn btn-sm btn-outline-primary"
                                                       target="_blank">
                                                        <i class="fas fa-download me-1"></i> Descargar material
                                                    </a>
                                                </div>
                                            @endif

                                            @if($actividad->tipo === 'video' && $actividad->video_url)
                                                <div class="ratio ratio-16x9 mb-3">
                                                    <iframe src="{{ $actividad->video_url }}" frameborder="0" allowfullscreen></iframe>
                                                </div>
                                            @endif

                                            <!-- Para alumnos: Formulario de respuesta -->
                                            @if(auth()->user()->isAlumno() && !$completada)
                                                <input type="hidden" name="respuestas[{{ $actividad->id }}][tipo]" value="{{ $actividad->tipo }}">

                                                @if($actividad->tipo === 'pregunta')
                                                    <div class="mb-3">
                                                        <label class="form-label">Tu respuesta:</label>
                                                        <textarea class="form-control"
                                                                  name="respuestas[{{ $actividad->id }}][respuesta]"
                                                                  rows="3" required></textarea>
                                                    </div>
                                                @elseif($actividad->tipo === 'opcion_multiple')
                                                    <div class="mb-3">
                                                        <label class="form-label">Selecciona una opción:</label>
                                                        @if(!empty($actividad->opciones))
                                                            @foreach($actividad->opciones as $key => $opcion)
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input" type="radio"
                                                                           name="respuestas[{{ $actividad->id }}][respuesta]"
                                                                           id="opcion_{{ $actividad->id }}_{{ $key }}"
                                                                           value="{{ $key }}" required>
                                                                    <label class="form-check-label" for="opcion_{{ $actividad->id }}_{{ $key }}">
                                                                        {{ $opcion }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                @elseif($actividad->tipo === 'verdadero_falso')
                                                    <div class="mb-3">
                                                        <label class="form-label">Selecciona:</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="respuestas[{{ $actividad->id }}][respuesta]"
                                                                   id="vf_{{ $actividad->id }}_verdadero"
                                                                   value="verdadero" required>
                                                            <label class="form-check-label" for="vf_{{ $actividad->id }}_verdadero">
                                                                Verdadero
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="respuestas[{{ $actividad->id }}][respuesta]"
                                                                   id="vf_{{ $actividad->id }}_falso"
                                                                   value="falso">
                                                            <label class="form-check-label" for="vf_{{ $actividad->id }}_falso">
                                                                Falso
                                                            </label>
                                                        </div>
                                                    </div>
                                                @elseif($actividad->tipo === 'archivo')
                                                    <div class="mb-3">
                                                        <label class="form-label">Sube tu archivo:</label>
                                                        <input type="file" class="form-control"
                                                               name="respuestas[{{ $actividad->id }}][archivo]" required>
                                                    </div>
                                                @elseif($actividad->tipo === 'video')
                                                    <div class="mb-3">
                                                        <label class="form-label">Comentarios:</label>
                                                        <textarea class="form-control"
                                                                  name="respuestas[{{ $actividad->id }}][respuesta]"
                                                                  rows="3" required></textarea>
                                                    </div>
                                                @elseif($actividad->tipo === 'texto')
                                                    <div class="alert alert-info">
                                                        <i class="fas fa-info-circle me-1"></i> Esta actividad se marcará como completada automáticamente al enviar.
                                                    </div>
                                                @endif
                                            @elseif(auth()->user()->isAlumno() && $completada)
                                                <div class="alert alert-success">
                                                    <i class="fas fa-check-circle me-1"></i> Ya completaste esta actividad.
                                                </div>
                                            @endif

                                            <!-- Para docentes: Respuestas correctas -->
                                            @if(auth()->user()->isDocente())
                                                @if(in_array($actividad->tipo, ['opcion_multiple', 'verdadero_falso']))
                                                    <div class="mb-3">
                                                        <label class="form-label">Opciones:</label>
                                                        <div class="list-group">
                                                            @if($actividad->tipo === 'opcion_multiple' && !empty($actividad->opciones))
                                                                @foreach($actividad->opciones as $key => $opcion)
                                                                    <div class="list-group-item {{ $actividad->respuesta_correcta == $key ? 'list-group-item-success' : '' }}">
                                                                        @if($actividad->respuesta_correcta == $key)
                                                                            <i class="fas fa-check-circle text-success me-2"></i>
                                                                        @endif
                                                                        {{ $opcion }}
                                                                    </div>
                                                                @endforeach
                                                            @elseif($actividad->tipo === 'verdadero_falso')
                                                                <div class="list-group-item {{ $actividad->respuesta_correcta == 'verdadero' ? 'list-group-item-success' : '' }}">
                                                                    @if($actividad->respuesta_correcta == 'verdadero')
                                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                                    @endif
                                                                    Verdadero
                                                                </div>
                                                                <div class="list-group-item {{ $actividad->respuesta_correcta == 'falso' ? 'list-group-item-success' : '' }}">
                                                                    @if($actividad->respuesta_correcta == 'falso')
                                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                                    @endif
                                                                    Falso
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="alert alert-secondary mt-3">
                                                    <h6 class="alert-heading">Información para el docente:</h6>
                                                    <ul class="mb-0">
                                                        <li><strong>Tipo:</strong> {{ ucfirst(str_replace('_', ' ', $actividad->tipo)) }}</li>
                                                        <li><strong>Permite archivo:</strong> {{ $actividad->permite_archivo ? 'Sí' : 'No' }}</li>
                                                        @if($actividad->respuesta_correcta)
                                                            <li><strong>Respuesta correcta:</strong>
                                                                @if($actividad->tipo === 'opcion_multiple')
                                                                    {{ $actividad->opciones[$actividad->respuesta_correcta] ?? 'N/A' }}
                                                                @else
                                                                    {{ ucfirst($actividad->respuesta_correcta) }}
                                                                @endif
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                @if(auth()->user()->isAlumno())
                                    @php
                                        $todasCompletadas = $sesion->actividades->every(function($actividad) {
                                            return $actividad->respuestasAlumno->where('estudiante_id', auth()->id())->where('estado', 'completada')->count() > 0;
                                        });
                                    @endphp

                                    @if(!$todasCompletadas)
                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-paper-plane me-1"></i> Enviar respuestas
                                            </button>
                                        </div>
                                    @endif
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
