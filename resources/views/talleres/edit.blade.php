@extends('layouts.app')

@section('content')
<div class="container py-5">

    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-center mb-4">Editar Taller</h2>

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow rounded-4">
                <div class="card-body">
                    <form action="{{ route('talleres.update', $taller) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" name="titulo" value="{{ old('titulo', $taller->titulo) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion', $taller->descripcion) }}</textarea>
                        </div>

                        @if($taller->materiales)
                            <div class="mb-3">
                                <label class="form-label">Archivo actual:</label>
                                <p>
                                    <a href="{{ asset('storage/' . $taller->materiales) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                        {{ basename($taller->materiales) }}
                                    </a>
                                </p>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="archivo" class="form-label">Cambiar archivo (opcional)</label>
                            <input type="file" name="archivo" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('talleres.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Secciones del taller --}}
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <h4 class="text-primary mb-3">Secciones del Taller</h4>

            @forelse($taller->secciones as $seccion)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-2">{{ $seccion->nombre }} <small class="text-muted">({{ ucfirst($seccion->tipo) }})</small></h5>
                        <p class="card-text">{{ Str::limit($seccion->descripcion, 150) }}</p>

                        <a href="{{ route('secciones.edit', $seccion->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Editar Sección
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-muted">Este taller aún no tiene secciones.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
