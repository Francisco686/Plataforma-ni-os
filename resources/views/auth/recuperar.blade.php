@extends('layouts.app')
@section('content')

<style>
    body {
        background: linear-gradient(to right, #d4f1f9, #fef6e4);
    }

    .contenedor-centrado {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem 1rem;
    }

    .recuperar-container {
        background-color: #ffffffee;
        border-radius: 16px;
        padding: 2rem;
        max-width: 400px;
        width: 100%;
        box-shadow: 0 0 20px rgba(0,0,0,0.2);
        font-family: 'Segoe UI', sans-serif;
        z-index: 2;
        position: relative;
    }

    .recuperar-title {
        font-size: 1.6rem;
        font-weight: bold;
        color: #198754;
        text-align: center;
        margin-bottom: 1rem;
    }

    .form-label {
        font-weight: bold;
        color: #333;
    }

    .btn-recuperar {
        background-color: #0d6efd;
        color: white;
        font-weight: bold;
        border-radius: 25px;
        padding: 0.5rem;
        width: 100%;
        border: none;
    }

    .btn-recuperar:hover {
        background-color: #084fc7;
    }

    .volver {
        text-align: center;
        margin-top: 1rem;
    }

    .volver a {
        color: #0d6efd;
        font-weight: bold;
        text-decoration: none;
    }

    .volver a:hover {
        text-decoration: underline;
    }

    @media (max-width: 576px) {
        .recuperar-container {
            padding: 1.5rem;
        }
    }
</style>

<div class="contenedor-centrado">
    <div class="recuperar-container">
        <div class="recuperar-title">🔐 Recuperar Contraseña</div>

        @if(session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('recuperar.enviar') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre de usuario docente</label>
                <input type="text" class="form-control" name="name" placeholder="Ej. Prof. Juan Pérez" required>
            </div>
            <button type="submit" class="btn-recuperar">Generar Contraseña Temporal</button>
        </form>

        <div class="volver">
            <a href="{{ route('login') }}">🔙 Volver al inicio de sesión</a>
        </div>
    </div>
</div>
@endsection
