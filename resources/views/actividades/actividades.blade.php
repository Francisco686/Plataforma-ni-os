{{-- resources/views/actividades/actividades.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <!-- Banner superior -->
        <div class="row mb-4">
            <div class="col text-center">
                <div class="px-4 py-3 rounded shadow-sm d-inline-block"
                     style="background-color: #a8edea; color: #000; max-width: 100%; min-width: 700px;">
                    <h2 class="mb-1" style="font-size: 2rem;">
                        @if($tallerSeleccionado)
                            Sesiones del Taller de {{ $tallerSeleccionado }}
                        @else
                            Sesiones de Actividades
                        @endif
                    </h2>
                    <p class="mb-0 small">
                        {{ auth()->user()->isDocente() ? 'Gestiona tus sesiones de actividades' : 'Sesiones asignadas por tus docentes' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Botones superiores -->
        <div class="row align-items-center mb-4">
            <div class="col-md-6">
                <a href="{{ route('actividades.index') }}"
                   class="btn mt-1"
                   style="background: linear-gradient(90deg, #a8edea, #43cea2); color: #000 !important; border: none; padding: 10px 40px; font-weight: 400; letter-spacing: 1px; border-radius: 8px; min-width: 250px; text-align: center; display: inline-block; transition: background 0.3s ease;">
                    <i class="fas fa-arrow-left me-2"></i> Volver
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                @if($sesiones->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-calendar-alt fa-4x text-muted mb-3"></i>
                        <h4>No hay sesiones disponibles</h4>
                        <p class="text-muted">
                            {{ auth()->user()->isDocente() ? 'Comienza creando tu primera sesión de actividades' : 'Aún no hay sesiones asignadas' }}
                        </p>
                    </div>
                @else
                    <!-- Mantén todo el código de tu tabla de sesiones existente -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                            <tr>
                                <th>Título</th>
                                <th>Tipos</th>
                                @if(auth()->user()->isAlumno())
                                    <th>Estado</th>
                                @endif
                                <th>Docente</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sesiones as $sesion)
                                @php
                                    $totalActividades = $sesion->actividades->count();
                                    $completadas = 0;
                                    $respondidaCompleta = false;

                                    if(auth()->user()->isAlumno()) {
                                        $completadas = $sesion->actividades->filter(function($actividad) {
                                            return $actividad->respuestasAlumno->where('estudiante_id', auth()->id())->where('estado', 'completada')->count() > 0;
                                        })->count();

                                        $respondidaCompleta = ($completadas == $totalActividades && $totalActividades > 0);
                                    }
                                @endphp
                                <tr class="{{ $respondidaCompleta ? 'table-success' : ($completadas > 0 ? 'table-warning' : 'table-light') }}">
                                    <td>{{ $sesion->titulo }}</td>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            @foreach($sesion->actividades as $actividad)
                                                <li>{{ ucfirst($actividad->tipo) }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    @if(auth()->user()->isAlumno())
                                        <td>
                                            @if($respondidaCompleta)
                                                @php
                                                    $correctas = 0;
                                                    $totalCalificables = 0;
                                                    foreach($sesion->actividades as $actividad) {
                                                        $respuesta = $actividad->respuestasAlumno->where('estudiante_id', auth()->id())->first();
                                                        if($respuesta && $respuesta->estado == 'completada') {
                                                            if(in_array($actividad->tipo, ['opcion_multiple', 'verdadero_falso'])) {
                                                                $totalCalificables++;
                                                                if($respuesta->respuesta == $actividad->respuesta_correcta) {
                                                                    $correctas++;
                                                                }
                                                            } else {
                                                                // Para otros tipos de actividad, se consideran correctas por enviarlas
                                                                $correctas++;
                                                            }
                                                        }
                                                    }
                                                    $totalActividades = $sesion->actividades->count();
                                                    $porcentaje = $totalActividades > 0 ? round(($correctas/$totalActividades)*100) : 0;
                                                    $tieneIncorrectas = ($correctas < $totalActividades);
                                                @endphp

                                                <span class="badge bg-{{ $tieneIncorrectas ? 'warning' : 'success' }}">
                {{ $tieneIncorrectas ? 'Completada con errores' : 'Completada correctamente' }}
            </span>
                                                <div class="mt-1 small text-{{ $tieneIncorrectas ? 'danger' : 'success' }}">
                                                    @if($tieneIncorrectas)
                                                        <i class="fas fa-exclamation-circle"></i>
                                                        {{ $correctas }}/{{ $totalActividades }} correctas ({{ $porcentaje }}%)
                                                        @if($totalCalificables > 0)
                                                            <div class="text-muted">
                                                                <small>Incluye {{ $totalCalificables }} preguntas calificadas</small>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <i class="fas fa-check-circle"></i>
                                                        ¡Correcto!  ({{ $porcentaje }}%)
                                                    @endif
                                                </div>
                                            @elseif($completadas > 0)
                                                <span class="badge bg-warning text-dark">En progreso</span>
                                                <div class="mt-1 small text-muted">
                                                    {{ $completadas }}/{{ $totalActividades }} actividades
                                                </div>
                                            @else
                                                <span class="badge bg-danger">Pendiente</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $sesion->docente->name }}</td>
                                    <td>{{ $sesion->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2 flex-wrap">
                                            @if(auth()->user()->isDocente())
                                                @if($sesion->actividades->isNotEmpty())
                                                    <a href="{{ route('actividades.show', [
                                                            'sesion' => $sesion->id,
                                                            'actividad' => $sesion->actividades->first()->id,
                                                            'taller_id' => $taller_id
                                                        ]) }}"
                                                       class="btn btn-sm btn-info me-2"
                                                       data-bs-toggle="tooltip" title="Ver actividad">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </a>
                                                @else
                                                    <button class="btn btn-sm btn-info me-2" disabled
                                                            data-bs-toggle="tooltip" title="No hay actividades para ver">
                                                        <i class="fas fa-eye"></i> Ver
                                                    </button>
                                                @endif

                                                <a href="{{ route('actividades.edit', $sesion->id) }}"
                                                   class="btn btn-sm btn-warning me-2"
                                                   data-bs-toggle="tooltip" title="Editar sesión">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('actividades.destroy', $sesion->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('¿Estás seguro de eliminar esta sesión?');"
                                                      style="display: inline-block; margin-bottom: 0;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="btn btn-sm btn-danger"
                                                            data-bs-toggle="tooltip" title="Eliminar sesión">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @else
                                                @if($sesion->actividades->isNotEmpty())
                                                    @if($respondidaCompleta)
                                                        <button class="btn btn-sm btn-secondary me-2" disabled
                                                                data-bs-toggle="tooltip" title="Ya respondiste esta sesión">
                                                            <i class="fas fa-check-circle"></i> Respondida
                                                        </button>
                                                    @else


                                                        {{--  <div class="debug-info bg-light p-2 mb-2 small">
                                                            <strong>Depuración:</strong><br>
                                                            Taller ID desde URL: {{ $taller_id ?? 'null' }}<br>
                                                            Taller ID primera actividad: {{ $sesion->actividades->first()->taller_id }}<br>
                                                            Coinciden: {{ ($taller_id == $sesion->actividades->first()->taller_id) ? 'Sí' : 'No' }}
                                                        </div> --}}
                                                        <a href="{{ route('actividades.show', [
                                                                'sesion' => $sesion->id,
                                                                'actividad' => $sesion->actividades->first()->id,
                                                                'taller_id' => $taller_id
                                                            ]) }}"
                                                           class="btn btn-sm btn-primary me-2"
                                                           data-bs-toggle="tooltip" title="Responder actividades">
                                                            <i class="fas fa-pencil-alt"></i> Responder
                                                        </a>
                                                    @endif
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            .btn-gradient {
                background: linear-gradient(90deg, #a8edea, #43cea2);
                color: #000 !important;
                border: none;
                padding: 10px 30px;
                font-weight: 500;
                border-radius: 8px;
                transition: background 0.3s ease;
            }
            .progress {
                min-width: 100px;
            }
            .table-success {
                background-color: rgba(25, 135, 84, 0.1);
            }
            .table-warning {
                background-color: rgba(255, 193, 7, 0.1);
            }
            .table-light {
                background-color: rgba(248, 249, 250, 0.5);
            }
        </style>
    @endpush

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(function (el) {
                    return new bootstrap.Tooltip(el);
                });
            });
        </script>
    @endsection
