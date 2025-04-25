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
                $asignacion = $taller->asignacion ?? null;
                $total = $taller->secciones->count();
                $completadas = $asignacion
                    ? $asignacion->progresos()->where('completado', true)->count()
                    : 0;
                $porcentaje = $total > 0 ? round(($completadas / $total) * 100) : 0;
            @endphp

            <div class="col-md-4 mb-4 d-flex">
                <div class="card border-success shadow h-100 w-100">
                    <div class="card-body text-center">
                        <h5 class="card-title text-success fw-bold">{{ $taller->nombre }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($taller->descripcion, 100) }}</p>
                        <p class="text-muted">Secciones: {{ $total }}</p>

                        <div class="progress mb-3" style="height: 22px;">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                 style="width: {{ $porcentaje }}%;">
                                {{ $porcentaje }}% Completado
                            </div>
                        </div>

                        <a href="{{ route('talleres.ver', $taller->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-right"></i> Ver Taller
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>No hay talleres disponibles.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
