@extends('layouts.app')

@section('content')

    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #fef6e4);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .pantalla-completa {
            min-height: 100vh;
            background: white;
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin: 1rem;
        }

        h3 {
            color: #0d6efd;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
        }

        .btn {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
        }

        .btn-primary {
            background-color: #198754;
            border: none;
        }

        .btn-primary:hover {
            background-color: #157347;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        .table-container {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background-color: #e3f2fd;
            color: #0c5460;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .table th, .table td {
            padding: 1rem;
            vertical-align: middle;
            border: none;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        .table td:first-child {
            font-weight: 600;
            color: #343a40;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.95rem;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .alert {
            border-radius: 0.5rem;
            font-size: 0.95rem;
            padding: 0.75rem 1.25rem;
        }

        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
            background: #f1f3f5;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
        }

        .filtros .form-group {
            flex: 1;
            min-width: 160px;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.5em 0.75em;
        }

        .modal-content {
            border-radius: 0.75rem;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            background-color: #0d6efd;
            color: white;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .accordion-button {
            border-radius: 0.5rem !important;
            margin-bottom: 0.5rem;
        }

        .accordion-button:not(.collapsed) {
            color: #0c5460;
            background-color: #e3f2fd;
        }

        .accordion-body {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
        }

        @media (max-width: 768px) {
            .pantalla-completa {
                padding: 1.5rem;
                margin: 0.5rem;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th, .table td {
                padding: 0.75rem;
            }

            .btn, .form-control {
                font-size: 0.85rem;
            }

            h3 {
                font-size: 1.8rem;
            }

            .filtros .form-group {
                min-width: 100%;
            }
        }
    </style>

    <div class="container-fluid d-flex justify-content-center align-items-start py-5" style="background: linear-gradient(to right, #e0f7fa, #fef6e4); min-height: 100vh;">
        <div class="col-lg-10 pantalla-completa">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary mb-4">
                <i class="fas fa-arrow-left me-1"></i> Regresar
            </a>

            <h3 class="mb-4"><i class="fas fa-clipboard-check me-2"></i>Evaluaciones de Alumnos</h3>

            <p class="text-muted mb-3">
                <i class="fas fa-user-friends me-1"></i> Total de alumnos: <strong>{{ $alumnos->count() }}</strong>
            </p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Filtros y buscador -->
            <form method="GET" action="{{ route('evaluaciones.index') }}" class="filtros">
                <div class="form-group">
                    <label for="grado">Grado</label>
                    <select name="grado" id="grado" class="form-control" onchange="this.form.submit()">
                        <option value="">Todos los grados</option>
                        @foreach($grados as $grado)
                            <option value="{{ $grado }}" {{ request('grado') == $grado ? 'selected' : '' }}>
                                {{ $grado }}°
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="grupo">Grupo</label>
                    <select name="grupo" id="grupo" class="form-control" onchange="this.form.submit()">
                        <option value="">Todos los grupos</option>
                        @foreach($letras as $letra)
                            <option value="{{ strtoupper($letra) }}" {{ request('grupo') == strtoupper($letra) ? 'selected' : '' }}>
                                {{ strtoupper($letra) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group flex-grow-1">
                    <label for="search">Buscar</label>
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar alumno..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>

            @if($alumnos->isEmpty())
                <div class="alert alert-info">No hay alumnos registrados en el sistema.</div>
            @else
                <div class="table-container">
                    <table class="table table-hover text-center">
                        <thead>
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
                                        {{ $alumno->group->grado ?? '' }}° {{ strtoupper($alumno->group->grupo ?? '') }}
                                    @else
                                        <span class="text-muted">Sin grupo</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#progresoModal{{ $alumno->id }}">
                                        <i class="fas fa-chart-line me-1"></i> Ver Progreso
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Modals para progreso de alumnos -->
            @foreach($alumnos as $alumno)
                <div class="modal fade" id="progresoModal{{ $alumno->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Progreso de {{ $alumno->apellido_paterno ?? '' }}
                                    {{ $alumno->apellido_materno ?? '' }}
                                    {{ $alumno->name }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <p><strong>Grado y Grupo:</strong>
                                            @if($alumno->group)
                                                {{ $alumno->group->grado ?? '' }}° {{ strtoupper($alumno->group->grupo ?? '') }}
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

                                <h5 class="text-center mb-4">Detalle de Sesiones y Actividades</h5>

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

                                                        <div class="table-container mt-3">
                                                            <table class="table table-sm">
                                                                <thead>
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
                                                                                    {{ $registro ? ucfirst(str_replace('_', ' ', $registro->estado)) : 'Pendiente' }}
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
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
