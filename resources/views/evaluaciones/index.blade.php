@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <div class="d-flex justify-content-center">

                <h2 class="text-center p-3 px-5 rounded" style="background-color:#cfe2ff; color: #000; min-width: 600px; max-width: 80%;">
                    Lista de Alumnos
                </h2>
            </div>


        <div class="mb-3">
            <a href="{{ url()->previous() }}" class="btn"
               style="background: linear-gradient(135deg, #0d6efd); color: #fff; border: none;">
                <i class="fas fa-arrow-left"></i> Regresar
            </a>
        </div>



    @if($alumnos->isEmpty())
            <div class="alert alert-info">No hay alumnos registrados en el sistema.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Nombre Completo</th>
                        <th>Grado y Grupo</th>
                        <th>Progreso</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($alumnos as $index => $alumno)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $alumno->apellido_paterno ?? '' }}
                                {{ $alumno->apellido_materno ?? '' }}
                                {{ $alumno->name }}
                            </td>
                            <td>
                                @if($alumno->group)
                                    {{ $alumno->group->grado ?? '' }}° {{ $alumno->group->grupo ?? '' }}
                                @else
                                    <span class="text-muted">Sin grupo</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#progresoModal{{ $alumno->id }}">
                                    <i class="fas fa-chart-line"></i> Ver Progreso
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Modals para progreso de alumnos -->
    @foreach($alumnos as $alumno)
        <div class="modal fade" id="progresoModal{{ $alumno->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            Progreso de {{ $alumno->apellido_paterno ?? '' }}
                            {{ $alumno->apellido_materno ?? '' }}
                            {{ $alumno->name }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Grado y Grupo:</strong>
                                    @if($alumno->group)
                                        {{ $alumno->group->grado ?? '' }}° {{ $alumno->group->grupo ?? '' }}
                                    @else
                                        <span class="text-muted">Sin grupo</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                @php
                                    $completadas = $actividadesAlumno[$alumno->id]->where('estado', 'completada')->count();
                                    $enProgreso = $actividadesAlumno[$alumno->id]->where('estado', 'en_progreso')->count();
                                    $totalActividades = $actividadesAlumno[$alumno->id]->count();
                                    $porcentaje = $totalActividades > 0 ? round(($completadas / $totalActividades) * 100) : 0;
                                @endphp
                                <p><strong>Progreso General:</strong>
                                    <span class="badge bg-{{ $porcentaje == 100 ? 'success' : ($porcentaje > 0 ? 'warning' : 'secondary') }}">
                                        {{ $completadas }} completadas, {{ $enProgreso }} en progreso ({{ $porcentaje }}%)
                                    </span>
                                </p>
                            </div>
                        </div>

                        <h5 class="text-center mb-3">Detalle de Sesiones y Actividades</h5>

                        @if($sesiones->isEmpty())
                            <div class="alert alert-info">No hay sesiones registradas en el sistema.</div>
                        @else
                            <div class="accordion" id="sesionesAccordion{{ $alumno->id }}">
                                @foreach($sesiones as $sesion)
                                    @php
                                        $actividadesSesion = $sesion->actividades;
                                        $actividadesAlumnoSesion = $actividadesAlumno[$alumno->id]->whereIn('actividad_id', $actividadesSesion->pluck('id'));
                                        $completadasSesion = $actividadesAlumnoSesion->where('estado', 'completada')->count();
                                        $enProgresoSesion = $actividadesAlumnoSesion->where('estado', 'en_progreso')->count();
                                        $pendientesSesion = $actividadesSesion->count() - $completadasSesion - $enProgresoSesion;
                                        $porcentajeSesion = $actividadesSesion->count() > 0 ? round(($completadasSesion / $actividadesSesion->count()) * 100) : 0;
                                    @endphp
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $sesion->id }}_{{ $alumno->id }}">
                                            <button class="accordion-button {{ $porcentajeSesion == 100 ? 'bg-success text-white' : ($porcentajeSesion > 0 ? 'bg-warning' : 'bg-light') }}"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $sesion->id }}_{{ $alumno->id }}"
                                                    aria-expanded="true" aria-controls="collapse{{ $sesion->id }}_{{ $alumno->id }}">
                                                <strong>Sesión:</strong> {{ $sesion->titulo }}
                                                <span class="badge ms-2 {{ $porcentajeSesion == 100 ? 'bg-light text-dark' : 'bg-dark' }}">
                                                    {{ $completadasSesion }}/{{ $actividadesSesion->count() }} completadas
                                                </span>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $sesion->id }}_{{ $alumno->id }}"
                                             class="accordion-collapse collapse"
                                             aria-labelledby="heading{{ $sesion->id }}_{{ $alumno->id }}"
                                             data-bs-parent="#sesionesAccordion{{ $alumno->id }}">
                                            <div class="accordion-body">
                                                <p><strong>Descripción:</strong> {{ $sesion->descripcion ?? 'Sin descripción' }}</p>
                                                <p><strong>Docente:</strong> {{ $sesion->docente->name ?? 'No asignado' }}</p>
                                                <p><strong>Creado:</strong> {{ $sesion->created_at->format('d/m/Y H:i') }}</p>

                                                <div class="table-responsive mt-3">
                                                    <table class="table table-sm table-bordered">
                                                        <thead class="table-light">
                                                        <tr>
                                                            <th>Actividad</th>
                                                            <th>Tipo</th>
                                                            <th>Estado</th>
                                                            <th>Fecha Inicio</th>
                                                            <th>Fecha Completado</th>
                                                            <th>Respuesta</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($actividadesSesion as $actividad)
                                                            @php
                                                                $registro = $actividadesAlumno[$alumno->id]->where('actividad_id', $actividad->id)->first();
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $actividad->pregunta ? Str::limit($actividad->pregunta, 100) : 'Actividad sin descripción' }}</td>
                                                                <td>{{ $actividad->tipo }}</td>
                                                                <td>
                                                                    <span class="badge bg-{{
                                                                        $registro && $registro->estado == 'completada' ? 'success' :
                                                                        ($registro && $registro->estado == 'en_progreso' ? 'warning' : 'secondary')
                                                                    }}">
                                                                        {{ $registro ? ucfirst(str_replace('_', ' ', $registro->estado)) : 'pendiente' }}
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    {{ $registro && $registro->fecha_inicio ? \Carbon\Carbon::parse($registro->fecha_inicio)->format('d/m/Y H:i') : '-' }}
                                                                </td>
                                                                <td>
                                                                    {{ $registro && $registro->fecha_completado ? \Carbon\Carbon::parse($registro->fecha_completado)->format('d/m/Y H:i') : '-' }}
                                                                </td>
                                                                <td>
                                                                    {{ $registro && $registro->respuesta ? Str::limit($registro->respuesta, 50) : '-' }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
