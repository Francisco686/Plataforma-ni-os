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
        <!-- Taller fijo: Agua -->
        <div class="col-md-4 mb-4 d-flex">
            <div class="card border-primary shadow-lg h-100">
                <div class="card-body text-center p-4">
                    <h4 class="card-title text-primary font-weight-bold mb-3" style="font-size: 1.4rem;">
                        Taller del Agua
                    </h4>
                    <p class="card-text mb-3" style="font-size: 1.1rem;">
                        Explora cuentos, datos curiosos y videos sobre el cuidado del agua.
                    </p>
                   <a href="{{ route('talleres.agua') }}" class="btn btn-success">Entrar</a>

                        <i class="fas fa-water mr-2"></i> Ver Taller
                    </a>
                </div>
            </div>
        </div>

        <!-- Taller fijo: Reciclaje -->
        <div class="col-md-4 mb-4 d-flex">
            <div class="card border-warning shadow-lg h-100">
                <div class="card-body text-center p-4">
                    <h4 class="card-title text-warning font-weight-bold mb-3" style="font-size: 1.4rem;">
                        Taller de Reciclaje
                    </h4>
                    <p class="card-text mb-3" style="font-size: 1.1rem;">
                        Aprende cómo reducir, reutilizar y reciclar desde casa con ejemplos interactivos.
                    </p>
                    <a href="{{ route('talleres.reciclaje') }}" class="btn btn-outline-warning mt-3 px-4 py-2">
                        <i class="fas fa-recycle mr-2"></i> Ver Taller
                    </a>
                </div>
            </div>
        </div>

        @forelse($talleres as $taller)
            @php
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
        @empty
            <div class="col-12 text-center">
                <p>No hay talleres disponibles.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection
