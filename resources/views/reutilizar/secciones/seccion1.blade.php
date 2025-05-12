@extends('layouts.nabvar')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Introducción a la Reutilización</h2>

        <form method="POST" action="{{ route('actividad.guardar', $seccion->id) }}">
            @csrf

            {{-- Pregunta 1 --}}
            <div class="mb-4">
                <label for="pregunta1" class="form-label"><strong>¿Qué es reutilización?</strong></label>
                <textarea name="pregunta1" id="pregunta1" rows="4" class="form-control" placeholder="Escribe la definición con tus propias palabras..." required></textarea>
            </div>

            {{-- Pregunta 2: Diferencias --}}
            <div class="mb-4">
                <label class="form-label"><strong>Escribe tres diferencias entre reciclar y reutilizar:</strong></label>
                @for($i = 1; $i <= 3; $i++)
                    <input type="text" name="pregunta2[]" class="form-control mb-2" placeholder="Diferencia {{ $i }}" required>
                @endfor
            </div>

            {{-- Pregunta 3: Objetos reutilizables --}}
            <div class="mb-4">
                <label class="form-label"><strong>Lista 5 objetos que se pueden reutilizar en casa:</strong></label>
                @for($i = 1; $i <= 5; $i++)
                    <input type="text" name="pregunta3[]" class="form-control mb-2" placeholder="Objeto {{ $i }}" required>
                @endfor
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check"></i> Enviar respuestas
            </button>
        </form>
    </div>
@endsection
