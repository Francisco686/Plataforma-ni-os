@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-plus-circle me-2"></i>Crear Nuevo Taller
                        </h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('talleres.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nombre" class="form-label">
                                    <i class="fas fa-heading me-1"></i>Nombre del Taller
                                </label>
                                <input type="text"
                                       class="form-control @error('nombre') is-invalid @enderror"
                                       id="nombre"
                                       name="nombre"
                                       value="{{ old('nombre') }}"
                                       required
                                       autofocus>

                                @error('nombre')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">
                                    <i class="fas fa-align-left me-1"></i>Descripción
                                </label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                          id="descripcion"
                                          name="descripcion"
                                          rows="4">{{ old('descripcion') }}</textarea>

                                @error('descripcion')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('talleres.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-times-circle me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Guardar Taller
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('styles')
        <style>
            .card {
                border-radius: 10px;
                border: none;
            }
            .card-header {
                border-radius: 10px 10px 0 0 !important;
            }
            .form-control {
                border-radius: 8px;
                padding: 10px 15px;
            }
            .btn {
                border-radius: 8px;
                padding: 10px 20px;
                font-weight: 500;
            }
        </style>
    @endsection

@endsection
