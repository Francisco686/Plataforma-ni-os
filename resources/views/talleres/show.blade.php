@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-4 text-success">Ambiente</h2>
    <p class="text-center text-muted mb-5">el ambiente, para los servicios</p>

    <h4 class="fw-semibold mb-4 text-primary">Secciones del Taller</h4>

    @foreach ($taller->secciones as $seccion)
        <div class="card mb-4 shadow-sm rounded-4">
            <div class="card-body">
                <h5 class="card-title">Cuestionario</h5>

                @if($seccion->tipo === 'texto')
                    <p><strong>Tipo:</strong> Texto</p>
                    <p>{{ $seccion->contenido }}</p>

                @elseif($seccion->tipo === 'actividad')
                    <p><strong>Tipo:</strong> Actividad</p>
                    <p>{{ $seccion->contenido }}</p>

                @elseif($seccion->tipo === 'test')
                    <form action="{{ route('respuestas.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="seccion_id" value="{{ $seccion->id }}">

                        <p><strong>Tipo:</strong> Test</p>
                        <p>responde cuidadosamente ✨</p>

                        <p class="fw-semibold">Pregunta:</p>
                        <p>{{ $seccion->contenido }}</p>

                        @php
                            $opciones = json_decode($seccion->opciones, true);
                        @endphp

                        @foreach($opciones as $i => $opcion)
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    name="respuesta"
                                    id="opcion{{ $seccion->id }}_{{ $i }}"
                                    value="{{ $opcion }}" required>
                                <label class="form-check-label" for="opcion{{ $seccion->id }}_{{ $i }}">
                                    {{ $opcion }}
                                </label>
                            </div>
                        @endforeach

                        <div class="mt-3 text-end">
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                Enviar
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endforeach

    <div class="text-center mt-4">
        <a href="{{ route('talleres.index') }}" class="btn btn-secondary px-4">
            ← Regresar
        </a>
    </div>
</div>
@endsection
