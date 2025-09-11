@extends('layouts.app')
@section('contenido-centro_login')
    @section('content')
        <style>
            :root {
                --cell-size: 50px;
                --cell-size-mobile: 40px;
            }

            body {
                background: linear-gradient(to bottom, #c6f3ff, #ffffff);
                overflow-x: hidden;
                position: relative;
                font-family: 'Comic Sans MS', cursive, sans-serif;
                margin: 0;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* --- Fondo animado --- */
            .background-animated {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                z-index: 0;
                pointer-events: none;
            }

            .balloon {
                position: absolute;
                width: 60px;
                height: 90px;
                border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
                animation: floatUp 8s linear infinite;
            }
            .balloon::after {
                content: '';
                position: absolute;
                bottom: -25px;
                left: 50%;
                width: 3px;
                height: 25px;
                background: #888;
                transform: translateX(-50%);
            }
            .balloon:nth-child(1) { left: 10%; animation-delay: 0s; background: radial-gradient(circle, #ff8eb8, #f14a72); }
            .balloon:nth-child(2) { left: 30%; animation-delay: 2s; background: radial-gradient(circle, #a4cafe, #2563eb); }
            .balloon:nth-child(3) { left: 70%; animation-delay: 1s; background: radial-gradient(circle, #ffd166, #f59e0b); }
            .balloon:nth-child(4) { left: 85%; animation-delay: 3s; background: radial-gradient(circle, #8ecae6, #3b82f6); }

            @keyframes floatUp {
                0% { bottom: -100px; opacity: 0.9; }
                100% { bottom: 110%; opacity: 0; }
            }

            .emoji {
                position: absolute;
                font-size: 2.8rem;
                opacity: 0.5;
                animation: float 20s ease-in-out infinite;
            }
            .emoji1 { top: 10%; left: 8%; animation-delay: 0s; }
            .emoji2 { top: 20%; right: 10%; animation-delay: 5s; }
            .emoji3 { bottom: 15%; left: 12%; animation-delay: 10s; }
            .emoji4 { bottom: 8%; right: 15%; animation-delay: 15s; }
            @keyframes float {
                0%, 100% { transform: translateY(0); }
                50% { transform: translateY(-40px); }
            }

            /* --- Estilos compartidos --- */
            h2 {
                font-size: 4rem;
                color: #0d6efd;
                font-weight: 900;
                text-shadow: 2px 2px #d0f0ff;
                margin-bottom: 1rem;
                text-align: center;
                font-family: 'Comic Sans MS', cursive, sans-serif;
            }

            .login-subtitle {
                font-size: 1.2rem;
                color: #2e7d32;
                text-align: center;
                margin-bottom: 1.5rem;
                font-family: 'Comic Sans MS', cursive, sans-serif;
            }

            .game-card {
                background-color: #ffffff;
                border-radius: 2rem;
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
                border: 2px dashed #ddd;
                padding: 2rem;
                position: relative;
                z-index: 2;
                width: 100%;
                max-width: 600px; /* Increased by 40px from 500px */
                margin: 0 auto;
            }

            .form-group {
                margin-bottom: 1rem;
            }

            .form-control {
                border-radius: 10px;
                font-size: 1rem;
                font-family: 'Comic Sans MS', cursive, sans-serif;
                border: 1px solid #ced4da;
                padding: 0.8rem;
            }

            .form-control::placeholder {
                color: #6c757d;
            }

            .input-group-text {
                background-color: #e8f5e9;
                border: none;
                border-radius: 10px 0 0 10px;
                font-size: 1rem;
                padding: 0.8rem;
            }

            .btn-solid {
                color: #fff;
                font-weight: 600;
                padding: 0.8rem;
                border-radius: 1rem;
                border: none;
                transition: all 0.3s ease;
                font-family: 'Comic Sans MS', cursive, sans-serif;
                width: 100%;
                text-align: center;
            }

            .btn-green {
                background-color: #28b823;
            }
            .btn-green:hover {
                background-color: #106e0e;
                transform: translateY(-1px);
            }

            .alert-success, .alert-danger {
                border-radius: 15px;
                font-family: 'Comic Sans MS', cursive, sans-serif;
                text-align: center;
                margin-bottom: 1rem;
                font-size: 1rem;
            }

            .alert-success {
                background-color: #d4edda;
                color: #116540;
                border: 1px solid #c3e6cb;
            }

            .alert-danger {
                background-color: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
            }

            .text-center a {
                color: #333333; /* Changed from blue to dark gray */
                font-family: 'Comic Sans MS', cursive, sans-serif;
                font-size: 0.9rem;
                text-decoration: none; /* Removed underline */
            }

            .text-center a:hover {
                color: #15803d; /* Hover color matches button hover for consistency */
            }

            @media (max-width: 768px) {
                h2 {
                    font-size: 2.8rem;
                }

                .login-subtitle {
                    font-size: 1rem;
                }

                .game-card {
                    padding: 1.5rem;
                    max-width: 90%;
                }

                .form-control {
                    font-size: 0.9rem;
                }

                .input-group-text {
                    font-size: 0.9rem;
                }

                .btn-solid {
                    font-size: 0.9rem;
                    padding: 0.6rem;
                }

                .text-center a {
                    font-size: 0.8rem;
                }

                .emoji {
                    display: none;
                }
            }


            .text-center.mt-3 a {
                color: white;
            }
        </style>

        <!-- Fondo animado -->
        <div class="background-animated">

            <div class="emoji emoji1">🎮</div>
            <div class="emoji emoji2">🧩</div>
            <div class="emoji emoji3">🔤</div>
            <div class="emoji emoji4">♻️</div>
        </div>

        <div class="container-fluid" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; z-index: 1;">
            <div class="game-card">
                <h2>🎒 Iniciar Sesión</h2>
                <div class="login-subtitle">
                    ¡Bienvenido a tu aventura ambiental interactiva!
                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
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
                                <i class="fas fa-user"></i>
                            </div>
                            <input type="text" name="name" id="name" class="form-control"
                                   placeholder="Tu nombre" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input type="password" name="password" id="password" class="form-control"
                                   placeholder="Tu contraseña" required>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-solid btn-green">
                            🚀 ¡Vamos!
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <a href="{{ route('register') }}" class="btn btn-solid btn-green">
                        ✨ Crear cuenta nueva
                    </a>
                </div>

                <div class="text-center mt-2">
                    <a href="{{ route('recuperar.form') }}">¿Olvidaste tu contraseña?</a>
                </div>
            </div>
        </div>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @endsection
