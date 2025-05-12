@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-5 display-6">Gestión de Talleres</h2>

    <div class="row justify-content-center g-4">
        {{-- Formulario --}}
        <div class="col-12 col-md-10 col-lg-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-primary text-white text-center rounded-top-4">
                    <h5 class="mb-0">Crear nuevo taller</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('talleres.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="titulo" class="form-label fw-semibold">Título del Taller</label>
                            <input type="text" class="form-control" name="titulo" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="archivo" class="form-label fw-semibold">Archivo (PDF o imagen)</label>
                            <input type="file" class="form-control" name="archivo" accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Asignar a:</label>

                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="todos" name="destinatarios[]" value="all">
                                <label class="form-check-label" for="todos">
                                    Todos los alumnos
                                </label>
                            </div>

                            @foreach($alumnos as $alumno)
                                <div class="form-check mb-1 alumno-checkbox">
                                    <input class="form-check-input alumno" type="checkbox" name="destinatarios[]" value="{{ $alumno->id }}" id="alumno-{{ $alumno->id }}">
                                    <label class="form-check-label" for="alumno-{{ $alumno->id }}">
                                        {{ $alumno->name }} - {{ $alumno->grupo->grado }}°{{ strtoupper($alumno->grupo->grupo) }}
                                    </label>
                                </div>
                            @endforeach

                            <div class="form-text mt-1" id="contadorSeleccionados">0 alumnos seleccionados</div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill">
                                <i class="fas fa-plus-circle me-2"></i>Crear y Asignar Taller
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Talleres creados --}}
        <div class="col-12 col-md-10 col-lg-6">
            <div class="card shadow rounded-4">
                <div class="card-header bg-dark text-white text-center rounded-top-4">
                    <h5 class="mb-0">Talleres creados</h5>
                </div>
                <div class="card-body px-4" style="max-height: 500px; overflow-y: auto;">
                    @forelse($talleres as $taller)
                        <div class="border-bottom pb-3 mb-3">
                            <h5 class="fw-bold text-primary mb-1">{{ $taller->titulo }}</h5>
                            <p class="mb-1">{{ $taller->descripcion }}</p>

                            @if($taller->materiales)
                                <p class="mb-2">
                                    <a href="{{ asset('storage/' . $taller->materiales) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        Ver material adjunto
                                    </a>
                                </p>
                            @endif

                            <p class="mb-2">
                                <strong>Asignado a:</strong>
                                {{ $taller->alumnos->count() > 0 ? implode(', ', $taller->alumnos->pluck('name')->toArray()) : 'Ninguno' }}
                            </p>

                            <div class="d-flex gap-2">
                                <a href="{{ route('talleres.edit', $taller) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="fas fa-edit"></i> Editar
                                </a>

                                {{-- Nuevo botón para agregar secciones --}}
                                <a href="{{ route('secciones.create', $taller) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-plus-circle"></i> Agregar Sección
                                </a>

                                <form action="{{ route('talleres.destroy', $taller) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este taller?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">Aún no hay talleres creados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Botón regresar --}}
    <div class="row justify-content-center my-4">
        <div class="col-auto">
            <a href="{{ route('home') }}" class="btn btn-secondary btn-lg px-5 rounded-pill shadow">
                <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
            </a>
        </div>
    </div>
</div>

{{-- Script para manejar los checkboxes --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const todos = document.getElementById('todos');
        const alumnos = document.querySelectorAll('.alumno');
        const contador = document.getElementById('contadorSeleccionados');

        function actualizarContador() {
            const seleccionados = Array.from(alumnos).filter(a => a.checked);
            if (todos.checked) {
                contador.textContent = 'Todos los alumnos seleccionados';
            } else {
                contador.textContent = `${seleccionados.length} alumno(s) seleccionados`;
            }
        }

        todos.addEventListener('change', function () {
            alumnos.forEach(a => {
                a.checked = false;
                a.disabled = todos.checked;
            });
            actualizarContador();
        });

        alumnos.forEach(a => {
            a.addEventListener('change', actualizarContador);
        });

        actualizarContador();
    });
</script>
@endsection
