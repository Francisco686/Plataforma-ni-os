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
                    // For students and teachers, show progress
                    $showProgress = auth()->user()->role !== 'administrador';
                    $porcentaje = 0;

                    if($showProgress) {
                        $asignacion = $taller->asignacion ?? null;
                        $total = $taller->secciones->count();
                        $completadas = $asignacion
                            ? $asignacion->progresos()->where('completado', true)->count()
                            : 0;
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
                                Secciones: {{ $taller->secciones->count() }}
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
                                @if(auth()->user()->role === 'alumno')
                                    <a href="{{ route('reutilizar.index', $taller->id) }}"
                                       class="btn btn-outline-primary mt-2 mr-2 px-4 py-2">
                                        <i class="fas fa-door-open mr-2"></i> Entrar
                                    </a>
                                @elseif(auth()->user()->role === 'administrador')
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
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="asignarModalLabel{{ $taller->id }}">
                                        <i class="fas fa-users me-2"></i>Gestión de Usuarios: {{ $taller->nombre }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Listado de usuarios asignados -->
                                    <div class="mb-4">
                                        <h6 class="fw-bold mb-3"><i class="fas fa-user-check me-2"></i>Usuarios Asignados</h6>
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Curp</th>
                                                    <th>Rol</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($taller->usuariosAsignados ?? [] as $usuario)
                                                    <tr>
                                                        <td>{{ $usuario->name }}</td>
                                                        <td>{{ $usuario->curp }}</td>
                                                        <td>{{ ucfirst($usuario->role) }}</td>
                                                        <td>
                                                            <form action="{{ route('talleres.asignar.destroy', ['taller' => $taller->id, 'usuario' => $usuario->id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                        title="Eliminar asignación"
                                                                        onclick="return confirm('¿Quitar a {{ $usuario->name }} de este taller?')">
                                                                    <i class="fas fa-user-minus"></i> Quitar
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">No hay usuarios asignados a este taller</td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Formulario para asignar nuevo usuario -->
                                    <hr>
                                    <h6 class="fw-bold mb-3"><i class="fas fa-user-plus me-2"></i>Asignar Nuevo Usuario</h6>
                                    <form action="{{ route('talleres.asignar.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="taller_id" value="{{ $taller->id }}">

                                        <div class="row g-3 align-items-end">
                                            <div class="col-md-8">
                                                <label for="user_id" class="form-label">Seleccionar Usuario</label>
                                                <select name="user_id" class="form-select" required>
                                                    <option value="" disabled selected>Selecciona un alumno</option>
                                                    @foreach($taller->usuariosNoAsignados ?? [] as $usuario)
                                                        <option value="{{ $usuario->id }}">
                                                            {{ $usuario->name }} {{ $usuario->email }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="fas fa-user-plus me-1"></i> Asignar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
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
                                                    <th>Tipo</th>
                                                    <th>Título</th>
                                                    <th>Contenido</th>
                                                    <th>Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($taller->secciones as $seccion)
                                                    <tr>
                                                        <td>{{ $seccion->tipo }}</td>
                                                        <td>{{ $seccion->titulo }}</td>
                                                        <td>{{ Str::limit($seccion->contenido, 50) }}</td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <button onclick="toggleEditForm('editSeccionForm{{ $seccion->id }}', this)"
                                                                        class="btn btn-sm btn-outline-warning"
                                                                        title="Editar">
                                                                    <i class="fas fa-edit"></i>
                                                                </button>
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
                                                    <!-- Formulario de edición (oculto inicialmente) -->
                                                    <tr id="editSeccionForm{{ $seccion->id }}" style="display: none;">
                                                        <td colspan="4">
                                                            <form action="{{ route('secciones.update', $seccion->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row g-3">
                                                                    <div class="col-md-4">
                                                                        <label for="tipo" class="form-label">Tipo</label>
                                                                        <input type="text" class="form-control" id="tipo" name="tipo" value="{{ $seccion->tipo }}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="titulo" class="form-label">Título</label>
                                                                        <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $seccion->titulo }}" required>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label for="contenido" class="form-label">Contenido</label>
                                                                        <textarea class="form-control" id="contenido" name="contenido">{{ $seccion->contenido }}</textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end gap-2 mt-3">
                                                                    <button type="button" class="btn btn-sm btn-secondary"
                                                                            onclick="toggleEditForm('editSeccionForm{{ $seccion->id }}', this)">
                                                                        Cancelar
                                                                    </button>
                                                                    <button type="submit" class="btn btn-sm btn-info">
                                                                        <i class="fas fa-save me-1"></i> Guardar Cambios
                                                                    </button>
                                                                </div>
                                                            </form>
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
                                                <div class="col-md-4">
                                                    <label for="tipo" class="form-label">Tipo</label>
                                                    <input type="text" class="form-control" id="tipo" name="tipo" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="titulo" class="form-label">Título</label>
                                                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="contenido" class="form-label">Contenido</label>
                                                    <textarea class="form-control" id="contenido" name="contenido"></textarea>
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

            function toggleEditForm(formId, button) {
                const form = document.getElementById(formId);
                if (form.style.display === 'none') {
                    // Oculta todos los demás formularios de edición primero
                    document.querySelectorAll('[id^="editSeccionForm"]').forEach(el => {
                        if (el.id !== formId) el.style.display = 'none';
                    });

                    form.style.display = 'table-row';
                    // Cambia el ícono del botón a un check (opcional)
                    button.innerHTML = '<i class="fas fa-check"></i>';
                    button.classList.remove('btn-outline-warning');
                    button.classList.add('btn-outline-success');
                } else {
                    form.style.display = 'none';
                    // Restaura el ícono original
                    button.innerHTML = '<i class="fas fa-edit"></i>';
                    button.classList.remove('btn-outline-success');
                    button.classList.add('btn-outline-warning');
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
            /* Estilo para el formulario de edición */
            [id^="editSeccionForm"] {
                background-color: #f8f9fa;
            }
            [id^="editSeccionForm"] td {
                padding: 15px;
                border-top: 2px solid #dee2e6;
                border-bottom: 2px solid #dee2e6;
            }
        </style>
    @endsection
@endsection
