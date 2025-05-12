@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Volver a la lista
    </a>

    <h3 class="mb-4">Información del Alumno</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Nombre completo:</strong> {{ $alumno->name }}</p>
            <p><strong>Apellido paterno:</strong> {{ $alumno->apellido_paterno }}</p>
            <p><strong>Apellido materno:</strong> {{ $alumno->apellido_materno }}</p>
            <p><strong>Contraseña:</strong> {{ $alumno->password_visible }}</p>
            <p><strong>Grupo:</strong>
                @if($alumno->grupo)
                    {{ $alumno->grupo->grado }}°{{ strtoupper($alumno->grupo->grupo) }}
                @else
                    No asignado
                @endif
            </p>
        </div>
    </div>
</div>
@endsection
