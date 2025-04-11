@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-primary">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="mb-0">
                                <i class="fas fa-edit me-2"></i>Editar Taller
                            </h3>
                            <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Volver
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('talleres.update', $taller->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="nombre" class="form-label fs-5">
                                    <i class="fas fa-heading me-2 text-primary"></i>Nombre del Taller
                                </label>
                                <input type="text"
                                       class="form-control form-control-lg @error('nombre') is-invalid @enderror"
                                       id="nombre"
                                       name="nombre"
                                       value="{{ old('nombre', $taller->nombre) }}"
                                       required
                                       autofocus
                                       placeholder="Ingrese el nombre del taller">

                                @error('nombre')
                                <div class="invalid-feedback fs-6">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="descripcion" class="form-label fs-5">
                                    <i class="fas fa-align-left me-2 text-primary"></i>Descripción
                                </label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                          id="descripcion"
                                          name="descripcion"
                                          rows="6"
                                          placeholder="Describa el contenido del taller">{{ old('descripcion', $taller->descripcion) }}</textarea>

                                @error('descripcion')
                                <div class="invalid-feedback fs-6">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            @if(auth()->user()->role === 'administrador')
                                <div class="mb-4">
                                    <h5 class="mb-3">
                                        <i class="fas fa-list-check me-2 text-primary"></i>Secciones del Taller
                                    </h5>

                                    <div id="secciones-container">
                                        @foreach($taller->secciones as $index => $seccion)
                                            <div class="seccion-item card mb-3 p-3 border-secondary">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <h6 class="mb-0">Sección {{ $index + 1 }}</h6>
                                                    <button type="button" class="btn btn-sm btn-danger remove-seccion">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                <input type="hidden" name="secciones[{{ $index }}][id]" value="{{ $seccion->id }}">
                                                <input type="text" class="form-control mb-2" name="secciones[{{ $index }}][nombre]"
                                                       value="{{ $seccion->nombre }}" placeholder="Nombre de la sección" required>
                                                <textarea class="form-control" name="secciones[{{ $index }}][descripcion]"
                                                          rows="2" placeholder="Descripción">{{ $seccion->descripcion }}</textarea>
                                            </div>
                                        @endforeach
                                    </div>

                                    <button type="button" id="add-seccion" class="btn btn-outline-primary mt-2">
                                        <i class="fas fa-plus me-2"></i>Añadir Sección
                                    </button>
                                </div>
                            @endif

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-save me-2"></i>Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Añadir nueva sección
                document.getElementById('add-seccion').addEventListener('click', function() {
                    const container = document.getElementById('secciones-container');
                    const index = container.children.length;

                    const newSeccion = `
                <div class="seccion-item card mb-3 p-3 border-secondary">
                    <div class="d-flex justify-content-between mb-2">
                        <h6 class="mb-0">Sección ${index + 1}</h6>
                        <button type="button" class="btn btn-sm btn-danger remove-seccion">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control mb-2" name="secciones[${index}][nombre]"
                           placeholder="Nombre de la sección" required>
                    <textarea class="form-control" name="secciones[${index}][descripcion]"
                              rows="2" placeholder="Descripción"></textarea>
                </div>
            `;

                    container.insertAdjacentHTML('beforeend', newSeccion);
                });

                // Eliminar sección
                document.addEventListener('click', function(e) {
                    if(e.target.classList.contains('remove-seccion') || e.target.closest('.remove-seccion')) {
                        const item = e.target.closest('.seccion-item');
                        if(item && document.querySelectorAll('.seccion-item').length > 1) {
                            item.remove();
                            // Reordenar números de sección
                            document.querySelectorAll('.seccion-item h6').forEach((el, idx) => {
                                el.textContent = Sección ${idx + 1};
                            });
                        } else {
                            alert('Debe haber al menos una sección');
                        }
                    }
                });
            });
        </script>
    @endsection

    @section('styles')
        <style>
            .card {
                border-radius: 12px;
            }
            .card-header {
                border-radius: 12px 12px 0 0 !important;
            }
            .form-control {
                border-radius: 8px;
                padding: 12px 15px;
            }
            .form-control-lg {
                font-size: 1.1rem;
            }
            textarea.form-control {
                min-height: 120px;
            }
            .btn-lg {
                padding: 10px 24px;
                font-size: 1.1rem;
            }
            .seccion-item {
                background-color: #f8f9fa;
                transition: all 0.3s ease;
            }
            .seccion-item:hover {
                background-color: #f1f3f5;
            }
        </style>
    @endsection
@endsection
