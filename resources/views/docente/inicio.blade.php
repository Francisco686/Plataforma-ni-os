@extends('layouts.app')

@section('content')
    <style>
        .card-option {
            height: 160px; /* Altura fija para ambas tarjetas */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }

        .card-option:hover {
            transform: scale(1.05);
        }
    </style>

    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-bold text-success">👩‍🏫 Bienvenido Docente</h2>
            <p class="text-muted">Aquí puedes gestionar alumnos y evaluar su progreso.</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-5 mb-4">
                <a href="{{ route('alumnos.index') }}" class="btn btn-success btn-lg w-100 card-option">
                    📋 Registrar Alumnos
                </a>
            </div>
            <div class="col-md-5 mb-4">
                <a href="{{ route('evaluaciones.index')  }}" class="btn btn-primary btn-lg w-100 card-option">
                    📊 Ver Evaluaciones
                </a>
            </div>
        </div>
    </div>
@endsection
