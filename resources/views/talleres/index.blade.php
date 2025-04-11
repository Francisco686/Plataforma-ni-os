@extends('layouts.nabvar')

@section('content')
    <div class="container mt-5">
        <h2 class="text-center text-primary mb-4">
            @if(auth()->user()->role === 'administrador')
                Gestión de Talleres
            @else
                Mis Talleres
            @endif
        </h2>

        @if(auth()->user()->role === 'administrador')
            <div class="row mb-4">
                <div class="col-md-6">
                    <a href="{{ route('talleres.create') }}" class="btn btn-success btn-block">
                        <i class="fas fa-plus-circle"></i> Crear Nuevo Taller
                    </a>
                </div>
            </div>
        @endif

        <div class="row">
            @forelse($talleres as $taller)
                @php
                    $showProgress = auth()->user()->role !== 'administrador' && auth()->user()->role !== 'alumno';
                    $porcentaje = 0;

                    if($showProgress) {
                        $asignacion = AsignaTaller::where('user_id', $userId)
                            ->where('taller_id', $taller->id)
                            ->first();

                        $total = $taller->secciones_count;
                        $completadas = $asignacion ? $asignacion->progresos()->where('completado', true)->count() : 0;
                        $porcentaje = $total > 0 ? round(($completadas / $total) * 100) : 0;
                    }
                @endphp

                <div class="col-md-4 mb-4 d-flex">
                    <div class="card border-info shadow-lg h-100">
                        <div class="card-body text-center p-4">
                            <h4 class="card-title text-success font-weight-bold mb-3" style="font-size: 1.4rem;">
                                {{ $taller->nombre }}
                            </h4>
                            <p class="card-text mb-3" style="font-size: 1.1rem;">
                                {{ Str::limit($taller->descripcion, 120) }}
                            </p>
                            <p class="text-muted mb-3" style="font-size: 1rem;">
                                Secciones: {{ $taller->secciones_count }}
                            </p>

                            @if($showProgress)
                                <div class="progress mb-3" style="height: 25px;">
                                    <div class="progress-bar bg-info progress-bar-striped" role="progressbar"
                                         style="width: {{ $porcentaje }}%; font-size: 0.9rem;">
                                        {{ $porcentaje }}% Completado
                                    </div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-center flex-wrap gap-2 mt-3">
                                <a href="{{ route('talleres.ver', $taller->id) }}"
                                   class="btn btn-outline-primary mt-2 mr-2 px-4 py-2">
                                    <i class="fas fa-door-open mr-2"></i> Entrar
                                </a>

                                @if(auth()->user()->role === 'administrador')
                                    <a href="{{ route('talleres.edit', $taller->id) }}"
                                       class="btn btn-outline-secondary mt-2 px-4 py-2">
                                        <i class="fas fa-edit mr-2"></i> Editar
                                    </a>

                                    <button class="btn btn-outline-info mt-2 px-4 py-2" data-bs-toggle="modal" data-bs-target="#seccionesModal{{ $taller->id }}">
                                        <i class="fas fa-list-ul mr-2"></i> Secciones
                                    </button>

                                    <button class="btn btn-outline-success mt-2 px-4 py-2" data-bs-toggle="modal" data-bs-target="#asignarModal{{ $taller->id }}">
                                        <i class="fas fa-user-plus mr-2"></i> Asignar
                                    </button>

                                    <form action="{{ route('talleres.destroy', $taller->id) }}" method="POST"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este taller?')" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger px-4 py-2" type="submit">
                                            <i class="fas fa-trash-alt mr-2"></i> Eliminar
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Asignar Taller -->
                @if(auth()->user()->role === 'administrador')
                    <div class="modal fade" id="asignarModal{{ $taller->id }}" tabindex="-1" aria-labelledby="asignarModalLabel{{ $taller->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('talleres.asignar.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="taller_id" value="{{ $taller->id }}">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="asignarModalLabel{{ $taller->id }}">Asignar Taller: {{ $taller->nombre }}</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="user_id" class="form-label">Seleccionar Usuario</label>
                                            <select name="user_id" class="form-select" required>
                                                <option value="" disabled selected>-- Selecciona un usuario --</option>
                                                @foreach($usuarios as $usuario)
                                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Asignar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Secciones -->
                    <div class="modal fade" id="seccionesModal{{ $taller->id }}" tabindex="-1" aria-labelledby="seccionesModalLabel{{ $taller->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title" id="seccionesModalLabel{{ $taller->id }}">
                                        <i class="fas fa-list-ul me-2"></i>Secciones del Taller: {{ $taller->nombre }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Listado de secciones existentes -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3"><i class="fas fa-list me-2"></i>Secciones Existentes</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Descripción</th>
                                                    <th>Orden</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($taller->secciones()->orderBy('orden')->get() as $seccion)
                                                    <tr>
                                                        <td>{{ $seccion->nombre }}</td>
                                                        <td>{{ Str::limit($seccion->descripcion, 50) }}</td>
                                                        <td>{{ $seccion->orden }}</td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <a href="{{ route('secciones.edit', $seccion->id) }}"
                                                                   class="btn btn-sm btn-outline-warning"
                                                                   title="Editar">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('secciones.destroy', $seccion->id) }}" method="POST"
                                                                      onsubmit="return confirm('¿Estás seguro de eliminar esta sección?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Botón para mostrar formulario de nueva sección -->
                                    <div class="text-end mb-3">
                                        <button id="toggleNuevaSeccion{{ $taller->id }}"
                                                class="btn btn-sm btn-success"
                                                onclick="toggleForm('nuevaSeccionForm{{ $taller->id }}', this)">
                                            <i class="fas fa-plus me-1"></i> Nueva Sección
                                        </button>
                                    </div>

                                    <!-- Formulario para nueva sección (oculto inicialmente) -->
                                    <div id="nuevaSeccionForm{{ $taller->id }}" style="display: none;">
                                        <hr>
                                        <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle me-2"></i>Agregar Nueva Sección</h6>
                                        <form action="{{ route('secciones.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="taller_id" value="{{ $taller->id }}">

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="nombre" class="form-label">Nombre</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="orden" class="form-label">Orden</label>
                                                    <input type="number" class="form-control" id="orden" name="orden" min="1" required>
                                                </div>
                                                <div class="col-12">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end gap-2 mt-3">

                                                <button type="submit" class="btn btn-info btn-sm">
                                                    <i class="fas fa-save me-1"></i> Guardar Sección
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-12 text-center">
                    <p>No hay talleres disponibles.</p>
                </div>
            @endforelse
        </div>
    </div>

    @section('scripts')
        <script>
            function toggleForm(formId, button) {
                const form = document.getElementById(formId);
                if (form.style.display === 'none') {
                    form.style.display = 'block';
                    button.innerHTML = '<i class="fas fa-minus me-1"></i> Ocultar';
                    button.classList.remove('btn-success');
                    button.classList.add('btn-warning');
                } else {
                    form.style.display = 'none';
                    button.innerHTML = '<i class="fas fa-plus me-1"></i> Nueva Sección';
                    button.classList.remove('btn-warning');
                    button.classList.add('btn-success');
                }
            }
        </script>
    @endsection

    @section('styles')
        <style>
            .card {
                border-radius: 10px;
                transition: transform 0.3s ease;
            }
            .card:hover {
                transform: translateY(-5px);
            }
            .modal-header {
                border-radius: 10px 10px 0 0 !important;
            }
            .btn-outline-info {
                color: #0dcaf0;
                border-color: #0dcaf0;
            }
            .btn-outline-info:hover {
                background-color: #0dcaf0;
                color: white;
            }
            .table-hover tbody tr:hover {
                background-color: rgba(13, 202, 240, 0.1);
            }
        </style>
    @endsection
@endsection
