@extends('layouts.app')
@section('clase-centro')
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

        /* --- Estilos del registro --- */
        .registro-docente {
            background-color: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            padding: 2rem;
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 540px; /* Matches login card width */
            margin: 0 auto;
        }

        .registro-docente h2 {
            font-size: 4rem;
            color: #0d6efd;
            font-weight: 900;
            text-shadow: 2px 2px #d0f0ff;
            text-align: center;
            margin-bottom: 1rem;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .registro-docente p {
            font-size: 1.2rem;
            color: #2e7d32;
            text-align: center;
            margin-bottom: 1.5rem;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .form-label {
            font-weight: 600;
            color: #212529;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            font-size: 1rem;
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
            background-color: #22c55e;
        }
        .btn-green:hover {
            background-color: #15803d;
            transform: translateY(-1px);
        }

        .alert-danger {
            border-radius: 15px;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            text-align: center;
            margin-bottom: 1rem;
            font-size: 1rem;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .footer-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .footer-link a {
            color: #333333;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            font-size: 0.9rem;
            text-decoration: none;
        }

        .footer-link a:hover {
            color: #15803d;
        }

        @media (max-width: 768px) {
            .registro-docente {
                padding: 1.5rem;
                max-width: 90%;
            }

            .registro-docente h2 {
                font-size: 2.8rem;
            }

            .registro-docente p {
                font-size: 1rem;
            }

            .form-control {
                font-size: 0.9rem;
            }

            .btn-solid {
                font-size: 0.9rem;
                padding: 0.6rem;
            }

            .footer-link a {
                font-size: 0.8rem;
            }

            .emoji {
                display: none;
            }
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
        <div class="registro-docente">
            <h2><i class="fas fa-user-tie me-2"></i> Registro Docente</h2>
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
                    <button type="submit" class="btn btn-solid btn-green">
                        <i class="fas fa-user-plus me-2"></i> Crear cuenta
                    </button>
                </div>
            </form>

            <div class="footer-link">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
