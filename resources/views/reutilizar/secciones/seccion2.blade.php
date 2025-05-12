@extends('layouts.nabvar')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Actividad: Reutilizando en Casa</h2>

        <form method="POST" action="{{ route('actividad.guardar', $seccion->id) }}">
            @csrf

            {{-- Pregunta 1 --}}
            <div class="mb-4">
                <label for="pregunta1" class="form-label"><strong>¿Por qué es importante reutilizar los materiales que usamos en casa?</strong></label>
                <textarea name="pregunta1" id="pregunta1" rows="4" class="form-control" placeholder="Escribe tu opinión aquí..." required>{{ old('pregunta1') }}</textarea>
            </div>

            {{-- Pregunta 2: Reutilizar tubos de cartón --}}
            <div class="mb-4">
                <label class="form-label"><strong>Escribe tres formas diferentes de reutilizar tubos de cartón:</strong></label>
                @for($i = 1; $i <= 3; $i++)
                    <input type="text" name="pregunta2[]" class="form-control mb-2" placeholder="Forma {{ $i }}" required value="{{ old("pregunta2.$i") }}">
                @endfor
            </div>

            {{-- Pregunta 3: Objetos que solemos tirar --}}
            <div class="mb-4">
                <label class="form-label"><strong>Lista 5 objetos que solemos tirar y una idea para reutilizarlos:</strong></label>
                @for($i = 1; $i <= 5; $i++)
                    <input type="text" name="pregunta3[]" class="form-control mb-2" placeholder="Objeto {{ $i }} - Idea para reutilizarlo" required value="{{ old("pregunta3.$i") }}">
                @endfor
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check"></i> Enviar respuestas
            </button>
        </form>
    </div>
@endsection
