@extends('layouts.app')
@section('content')

<style>
    .form-box {
        background: #ffffffee;
        border-radius: 16px;
        padding: 2rem;
        max-width: 420px;
        margin: 3rem auto;
        box-shadow: 0 0 20px rgba(0,0,0,0.2);
        font-family: 'Segoe UI', sans-serif;
    }

    .form-box h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #198754;
    }

    .btn-save {
        width: 100%;
        border-radius: 25px;
        background-color: #0d6efd;
        color: #fff;
        padding: 0.6rem;
        font-weight: bold;
        border: none;
    }

    .btn-save:hover {
        background-color: #084fc7;
    }
</style>

<div class="form-box">
    <h2>🔒 Cambia tu contraseña</h2>

    <form method="POST" action="{{ route('docente.password.actualizar') }}">
        @csrf
        <div class="mb-3">
            <label>Nueva contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn-save">Guardar y cerrar sesión</button>
    </form>
</div>
@endsection
