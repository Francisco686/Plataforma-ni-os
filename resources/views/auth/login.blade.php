@extends('layouts.app')
@section('clase-centro', 'contenido-centro_login')
@section('content')

<style>
    .login-container {
        border-radius: 20px;
        padding: 2rem;
        max-width: 420px;
        margin: 2rem auto;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        font-family: 'Comic Sans MS', cursive;
        position: relative;
        z-index: 2;
    }

    .login-title {
        font-size: 1.8rem;
        color: #0d6efd;
        font-weight: bold;
        text-align: center;
        margin-bottom: 0.5rem;
    }

    .login-subtitle {
        font-size: 1rem;
        color: #198754;
        text-align: center;
        margin-bottom: 1rem;
    }

    .form-control {
        border-radius: 10px;
        font-size: 1rem;
    }

    .btn-user {
        background-color: #ffc107;
        color: #000;
        border: none;
        font-weight: bold;
        border-radius: 30px;
        padding: 0.6rem;
        transition: all 0.3s ease;
    }

    .btn-user:hover {
        background-color: #ff9800;
        color: white;
    }

    .input-group-text {
        background-color: #e0f7fa;
        border: none;
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    .text-center a {
        color: #0d6efd;
        font-weight: bold;
    }

    .emoji-float {
        position: absolute;
        font-size: 2rem;
        animation: mover 12s linear infinite;
        opacity: 0.8;
        z-index: 0;
    }

    .emoji-float:nth-child(1) { top: 10%; left: -10%; animation-delay: 0s; }
    .emoji-float:nth-child(2) { top: 25%; left: -15%; animation-delay: 3s; }
    .emoji-float:nth-child(3) { top: 40%; left: -20%; animation-delay: 6s; }
    .emoji-float:nth-child(4) { top: 55%; left: -12%; animation-delay: 9s; }
    .emoji-float:nth-child(5) { top: 70%; left: -18%; animation-delay: 12s; }

    @keyframes mover {
        0% { transform: translateX(0); }
        100% { transform: translateX(130vw); }
    }

    @media (max-width: 576px) {
        .login-container {
            padding: 1.5rem;
        }

        .login-title {
            font-size: 1.5rem;
        }
    }
</style>

<!-- Emojis flotando -->
<div class="emoji-float">🦊</div>
<div class="emoji-float">🦄</div>
<div class="emoji-float">🐢</div>
<div class="emoji-float">⚽</div>
<div class="emoji-float">⭐</div>
<div class="emoji-float">🦋</div>
<div class="emoji-float">🌈</div>
<div class="emoji-float">🐸</div>
<div class="emoji-float">🎈</div>
<div class="emoji-float">🌻</div>

<div class="login-container">
    <div class="login-title">
        🎒 Iniciar Sesión
    </div>
    <div class="login-subtitle">
        ¡Bienvenido a tu aventura ambiental interactiva!
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
                <div class="input-group-text">
                    <i class="fas fa-hat-cowboy"></i>
                </div>
                <input type="text" name="name" id="name" class="form-control"
                       placeholder="Tu nombre" required>
            </div>
        </div>

        <div class="form-group">
            <div class="input-group">
                <div class="input-group-text">
                    👦
                </div>
                <input type="password" name="password" id="password" class="form-control"
                       placeholder="Tu contraseña" required>
            </div>
        </div>

        <div class="form-group text-center">
            <button type="submit" class="btn btn-user btn-block">
                🚀 ¡Vamos!
            </button>
        </div>
    </form>

   <div class="text-center mt-2">
    <a href="{{ route('recuperar.form') }}">¿Olvidaste tu contraseña?</a>
</div>


    <div class="text-center mt-3">
        <a href="{{ route('register') }}" class="btn btn-user btn-block" style="background-color: #0dcaf0; color: black;">
            ✨ Crear cuenta nueva
        </a>
    </div>
</div>

@endsection
