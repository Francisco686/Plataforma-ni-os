@extends('layouts.app')
@section('clase-centro', 'contenido-centro_login')
@section('content')

<style>
    .registro-docente {
        background: #ffffff;
        border-radius: 16px;
        padding: 2.5rem;
        max-width: 480px;
        margin: 2rem auto;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    .registro-docente h2 {
        font-weight: 700;
        color: #0d6efd;
        text-align: center;
        margin-bottom: 1rem;
    }

    .registro-docente p {
        text-align: center;
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: #212529;
    }

    .form-control {
        border-radius: 8px;
        padding: 0.6rem;
    }

    .btn-registrar {
        border-radius: 30px;
        padding: 0.6rem;
        font-weight: bold;
        font-size: 1rem;
        background-color: #0d6efd;
        color: #fff;
        border: none;
        transition: 0.3s ease;
    }

    .btn-registrar:hover {
        background-color: #084fc7;
    }

    .footer-link {
        text-align: center;
        margin-top: 1.5rem;
    }

    .footer-link a {
        color: #0d6efd;
        font-weight: 600;
        text-decoration: none;
    }

    .footer-link a:hover {
        text-decoration: underline;
    }

    @media (max-width: 576px) {
        .registro-docente {
            padding: 1.5rem;
        }

        .registro-docente h2 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="registro-docente">
    <h2><i class="fas fa-user-tie me-2"></i>Registro Docente</h2>
    <p>Regístrate para acceder a la plataforma educativa ambiental como docente responsable.</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nombre completo</label>
            <input id="name" type="text" class="form-control" name="name" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" type="password" class="form-control" name="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <div class="d-grid mt-4">
            <button type="submit" class="btn btn-registrar">
                <i class="fas fa-user-plus me-2"></i> Crear cuenta
            </button>
        </div>
    </form>

    <div class="footer-link">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
    </div>
</div>

@endsection
