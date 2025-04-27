@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-4">
        <h2 class="fw-bold">{{ $taller->titulo }}</h2>
        <p class="text-muted">{{ $taller->descripcion }}</p>
    </div>

    @if($taller->materiales)
        <div class="text-center mb-5">
            <a href="{{ asset('storage/' . $taller->materiales) }}" target="_blank" class="btn btn-outline-primary">
                <i class="fas fa-file-alt me-1"></i> Ver material adjunto
            </a>
        </div>
    @endif

    {{-- Secciones del taller --}}
    <div class="mb-5">
        <h4 class="text-primary mb-3">Secciones del Taller</h4>

        @forelse($taller->secciones as $seccion)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $seccion->nombre }}</h5>
                    <p class="card-subtitle mb-2 text-muted">Tipo: <strong>{{ ucfirst($seccion->tipo) }}</strong></p>
                    <p class="card-text">{{ $seccion->descripcion }}</p>

                    @if($seccion->tipo === 'lectura')
                        <div class="alert alert-info">
                            📖 Esta sección es solo de lectura.
                        </div>

                    @elseif($seccion->tipo === 'actividad')
                        <div class="alert alert-warning">
                            ✏️ Esta sección requiere que realices una actividad. (funcionalidad en desarrollo)
                        </div>

                    @elseif($seccion->tipo === 'test')
                        <form>
                            <p class="fw-semibold">Pregunta:</p>
                            <p>{{ $seccion->contenido }}</p>
                            @php $opciones = json_decode($seccion->opciones, true); @endphp

                            @foreach($opciones as $i => $opcion)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="respuesta_{{ $seccion->id }}" id="opcion{{ $seccion->id }}_{{ $i }}">
                                    <label class="form-check-label" for="opcion{{ $seccion->id }}_{{ $i }}">
                                        {{ $opcion }}
                                    </label>
                                </div>
                            @endforeach
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="alert alert-secondary">
                Este taller aún no tiene secciones asignadas.
            </div>
        @endforelse
    </div>

    <div class="text-center">
        <a href="{{ route('talleres.index') }}" class="btn btn-secondary rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Regresar
        </a>
    </div>
</div>
@endsection
