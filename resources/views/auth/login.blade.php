@extends('layouts.app')

@section('content')
<div class="card o-hidden border-0 shadow-lg" style="max-height: 560px;">
    <div class="card-body p-4">
        <div class="text-center mb-3">
            <h1 class="h4 text-gray-900">Iniciar Sesión</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger text-center">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                    </div>
                    <input type="text" name="name" id="name" class="form-control"
                           placeholder="Nombre del alumno" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    </div>
                    <input type="password" name="password" id="password" class="form-control"
                           placeholder="Contraseña" required>
                </div>
            </div>

            <div class="form-group text-center mt-4">
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    <i class="fas fa-sign-in-alt"></i> Ingresar
                </button>
            </div>
        </form>

        <div class="text-center mt-2">
            <a class="small text-primary" href="#">¿Olvidaste tu contraseña?</a>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('register') }}" class="btn btn-primary btn-user btn-block">
                <i class="fas fa-user-plus"></i> ¿No tienes cuenta? Regístrate aquí
            </a>
        </div>
    </div>
</div>
<div style="width: 100%; background-color: #0d6efd; color: white; text-align: center; padding: 12px 10px; font-weight: bold; font-size: 1.1rem; margin-top: 8px; margin-bottom: 20px; border-radius: 8px;">
    Autor: Juan Francisco Jiménez Garduñoo - TESVB
</div>

@endsection
