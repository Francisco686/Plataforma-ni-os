@extends('layouts.app')
@section('clase-centro', 'contenido-centro_login')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow rounded-4">
                <div class="card-header bg-success text-white text-center">
                    <h4>Crear Cuenta Docente</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre Completo</label>
                            <input id="name" type="text" class="form-control" name="name" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i> Registrarse
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
