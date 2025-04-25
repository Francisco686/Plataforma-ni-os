@extends('layouts.nabvar')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">
        Taller: {{ $taller->nombre }}
    </h2>

    <p class="text-center text-muted mb-5">
        {{ $taller->descripcion }}
    </p>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            @foreach($secciones as $seccion)
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <strong>Sección {{ $seccion->orden }}: {{ $seccion->nombre }}</strong>

                        @if(in_array($seccion->id, $progreso))
                            <span class="badge bg-success">✅ Completado</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <p>{{ $seccion->descripcion ?? 'Sin descripción' }}</p>

                        @if(!in_array($seccion->id, $progreso))
                            <form method="POST" action="{{ route('talleres.completar') }}">
                                @csrf
                                <input type="hidden" name="asigna_taller_id" value="{{ $asignacion->id }}">
                                <input type="hidden" name="seccion_taller_id" value="{{ $seccion->id }}">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check-circle me-1"></i> Marcar como completado
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
