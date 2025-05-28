@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(to right, #d4f1f9, #fef6e4);
        font-family: 'Comic Sans MS', cursive;
    }

    .pantalla-completa {
        min-height: 100vh;
        padding: 3rem 1rem;
        display: flex;
        justify-content: center;
        align-items: flex-start;
    }

    .registro-alumno-container {
        width: 100%;
        max-width: 600px;
        background: white;
        border-radius: 25px;
        box-shadow: 0 0 25px rgba(0, 123, 255, 0.2);
        padding: 2rem 2.5rem;
        position: relative;
        z-index: 1;
    }

    .registro-alumno-container h3 {
        color: #0d6efd;
        font-weight: bold;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .form-group label {
        font-weight: bold;
        color: #198754;
    }

    .form-control {
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .btn-danger {
        background-color: #fd5d5d;
        border: none;
        font-weight: bold;
    }

    .btn-danger:hover {
        background-color: #e04848;
    }

    .btn-secondary {
        font-weight: bold;
    }

    .emoji-decor {
        position: absolute;
        font-size: 2rem;
        opacity: 0.6;
        animation: floatEmoji 6s ease-in-out infinite;
    }

    .emoji1 { top: 5%; left: 10%; }
    .emoji2 { bottom: 10%; right: 15%; }
    .emoji3 { top: 20%; right: 10%; }

    @keyframes floatEmoji {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    @media (max-width: 768px) {
        .emoji-decor {
            display: none;
        }

        .pantalla-completa {
            padding: 2rem 1rem;
        }

        .registro-alumno-container {
            margin: 0;
        }
    }
</style>

<!-- Emojis flotando -->
<div class="emoji-decor emoji1">🧒</div>
<div class="emoji-decor emoji2">📘</div>
<div class="emoji-decor emoji3">🌱</div>

<div class="pantalla-completa">
    <div class="registro-alumno-container">
        <h3>📋 Registrar Alumno</h3>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('alumnos.store') }}">
            @csrf

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="apellido_paterno">Apellido Paterno</label>
                <input type="text" name="apellido_paterno" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="apellido_materno">Apellido Materno</label>
                <input type="text" name="apellido_materno" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="text" name="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="grado">Grado</label>
                <select name="grado" id="grado" class="form-control" required>
                    <option value="">Selecciona un grado</option>
                    @foreach([1,2,3,4,5,6] as $grado)
                        <option value="{{ $grado }}">{{ $grado }}°</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="grupo">Grupo</label>
                <select name="grupo" id="grupo" class="form-control" required>
                    <option value="">Selecciona un grupo</option>
                    @foreach(['A','B','C'] as $grupo)
                        <option value="{{ $grupo }}">{{ strtoupper($grupo) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Cancelar
                </a>
                <button type="submit" class="btn btn-danger text-white">
                    <i class="fas fa-save me-1"></i> Guardar
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
