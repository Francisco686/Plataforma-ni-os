@extends('layouts.app')

@section('content')
<style>
    .fondo-info {
        min-height: 100vh;
        background: linear-gradient(to right, #d4f1f9, #fef6e4);
        padding: 3rem 1rem;
        display: flex;
        justify-content: center;
    }

    .info-container {
        background: white;
        border-radius: 20px;
        padding: 2rem 2.5rem;
        max-width: 700px;
        width: 100%;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
    }

    h3 {
        color: #0d6efd;
        font-weight: bold;
        text-align: center;
        margin-bottom: 2rem;
    }

    .card {
        border: none;
        background-color: #f9f9f9;
        border-radius: 15px;
    }

    .card-body p {
        font-size: 1.1rem;
        margin-bottom: 0.8rem;
        color: #212529; /* texto negro */
    }

    .card-body strong {
        color: #198754;
    }

    .btn-outline-secondary {
        font-weight: bold;
    }
</style>

<div class="fondo-info">
    <div class="info-container">
        <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Volver a la lista
        </a>

        <h3>📄 Información del Alumno</h3>

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
</div>
@endsection
