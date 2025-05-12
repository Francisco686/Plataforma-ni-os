@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow rounded-4">
                <div class="card-header bg-gradient text-white" style="background: linear-gradient(90deg, #007bff, #00c851);">
                    <h4 class="mb-0">
                        <i class="fas fa-plus-circle me-2"></i> Crear Nuevo Taller
                    </h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('talleres.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="titulo" class="form-label">
                                <i class="fas fa-heading me-1"></i> Título del Taller
                            </label>
                            <input type="text"
                                   class="form-control @error('titulo') is-invalid @enderror"
                                   id="titulo"
                                   name="titulo"
                                   value="{{ old('titulo') }}"
                                   placeholder="Ej. Cuidado del Agua"
                                   required>
                            @error('titulo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">
                                <i class="fas fa-align-left me-1"></i> Descripción
                            </label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                      id="descripcion"
                                      name="descripcion"
                                      rows="4"
                                      placeholder="Describe brevemente el contenido del taller"
                                      required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="archivo" class="form-label">
                                <i class="fas fa-file-upload me-1"></i> Archivo adicional (opcional)
                            </label>
                            <input type="file"
                                   name="archivo"
                                   class="form-control"
                                   accept=".pdf,.jpg,.jpeg,.png">
                            <small class="text-muted">Puedes subir archivos .pdf o imágenes del taller</small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('talleres.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times-circle me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i> Guardar Taller
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
