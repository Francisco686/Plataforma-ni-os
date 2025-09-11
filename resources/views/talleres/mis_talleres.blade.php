@extends('layouts.app')

@section('content')

    <style>
        body {
            background: linear-gradient(to bottom, #c6f3ff, #ffffff);
            overflow-x: hidden;
            position: relative;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        /* --- Fondo animado SOLO para alumnos --- */
        @if(Auth::user()->role === 'alumno')
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
            width: 50px;
            height: 75px;
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
            font-size: 2.5rem;
            opacity: 0.5;
            animation: float 8s ease-in-out infinite;
        }
        .emoji1 { top: 10%; left: 8%; }
        .emoji2 { top: 20%; right: 10%; }
        .emoji3 { bottom: 15%; left: 12%; }
        .emoji4 { bottom: 8%; right: 15%; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @endif

        /* --- Estilos compartidos --- */
        h1 {
            font-size: 4.2rem;
            color: #0d6efd;
            font-weight: 900;
            text-shadow: 3px 3px #d0f0ff;
            margin-bottom: 2.5rem;
            text-align: center;
            animation: pulse 2s infinite;
        }

        h4 {
            font-size: 2rem;
            font-weight: 700;
            text-shadow: 1px 1px #d0f0ff;
            margin-bottom: 1.2rem;
        }

        .card {
            border-radius: 1.5rem;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            padding: 2rem;
            min-height: 360px;
            width: 100%;
            max-width: 490px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 123, 255, 0.3);
        }

        .card-img-top {
            height: 380px;
            object-fit: contain;
            margin: 1.5rem auto;
        }

        .card-text {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .card-actions {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            align-items: center;
        }

        .btn-solid {
            color: #fff;
            font-weight: 600;
            padding: 0.7rem 1.8rem;
            border-radius: 1rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-green { background-color: #22c55e; }
        .btn-green:hover { background-color: #15803d; transform: translateY(-2px); }

        .btn-blue { background-color: #3b82f6; }
        .btn-blue:hover { background-color: #1e40af; transform: translateY(-2px); }

        .btn-yellow { background-color: #eab308; }
        .btn-yellow:hover { background-color: #a16207; transform: translateY(-2px); }

        .btn-purple { background-color: #8b5cf6; }
        .btn-purple:hover { background-color: #5b21b6; transform: translateY(-2px); }

        .btn-back {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
        }

        .cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
            padding: 2rem 0;
        }

        .no-talleres {
            font-size: 1.5rem;
            color: #6c757d;
            text-shadow: 1px 1px #d0f0ff;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2.8rem;
            }

            h4 {
                font-size: 1.6rem;
            }

            .card {
                min-height: 300px;
                max-width: 340px;
                padding: 1.5rem;
            }

            .card-img-top {
                height: 120px;
            }

            .card-text {
                font-size: 1.1rem;
            }

            .btn-solid {
                font-size: 1rem;
                padding: 0.6rem 1.5rem;
            }

            .cards-container {
                flex-direction: column;
                align-items: center;
                gap: 1.5rem;
            }

            .no-talleres {
                font-size: 1.3rem;
            }
        }
    </style>

    <!-- Fondo animado SOLO para alumnos -->
    @if(Auth::user()->role === 'alumno')
        <div class="background-animated">

            <div class="emoji emoji1">🦊</div>
            <div class="emoji emoji2">🧸</div>
            <div class="emoji emoji3">🦋</div>
            <div class="emoji emoji4">🐸</div>
        </div>
    @endif

    <div class="container-fluid py-5" style="min-height: 100vh; position: relative; z-index: 1;">
        <!-- Botón de regreso -->
        <div class="btn-back">
            <a href="{{ route('home') }}" class="btn btn-solid btn-blue animate__animated animate__fadeIn">
                <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
            </a>
        </div>

        <!-- Título -->
        <h1 class="animate__animated animate__pulse">🌱 ¡Explora tus Talleres! 🌱</h1>

        @if(session('success'))
            <div class="alert alert-success animate__animated animate__fadeIn text-center" style="max-width: 600px; margin: 1rem auto;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Contenedor de tarjetas -->
        <div class="cards-container">
            <!-- Taller fijo: Agua -->
            <div class="col-md-3">
                <div class="card animate__animated animate__zoomIn">
                    <div class="card-body text-center">
                        <img src="{{ asset('img/agua.png') }}" alt="Agua" class="card-img-top">
                        <h4 class="text-primary">💧 Taller del Agua</h4>
                        <p class="card-text">Aprende a cuidar el agua con cuentos, juegos y actividades.</p>
                        <div class="card-actions">
                            <a href="{{ route('talleres.agua') }}" class="btn btn-solid btn-blue">
                                <i class="fas fa-tint me-2"></i> ¡Vamos!
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Taller fijo: Reciclaje -->
            <div class="col-md-3">
                <div class="card animate__animated animate__zoomIn">
                    <div class="card-body text-center">
                        <img src="{{ asset('img/reciclaje.png') }}" alt="Reciclaje" class="card-img-top">
                        <h4 class="text-warning">♻️ Taller de Reciclaje</h4>
                        <p class="card-text">Descubre cómo reciclar de forma divertida y creativa.</p>
                        <div class="card-actions">
                            <a href="{{ route('talleres.reciclaje') }}" class="btn btn-solid btn-yellow">
                                <i class="fas fa-recycle me-2"></i> ¡A reciclar!
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Taller fijo: Reutilizar -->
            <div class="col-md-3">
                <div class="card animate__animated animate__zoomIn">
                    <div class="card-body text-center">
                        <img src="{{ asset('img/reutilizarfeliz.png') }}" alt="Reutilizar" class="card-img-top">
                        <h4 class="text-success">🔁 Taller de Reutilizar</h4>
                        <p class="card-text">Dale una segunda vida a los objetos con actividades creativas.</p>
                        <div class="card-actions">
                            <a href="{{ route('talleres.reutilizar') }}" class="btn btn-solid btn-green">
                                <i class="fas fa-sync-alt me-2"></i> ¡Reutilicemos!
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas dinámicas -->
            @foreach($talleres as $taller)
                <div class="col-md-3">
                    <div class="card animate__animated animate__zoomIn">
                        <div class="card-body text-center">
                            <h4 class="text-dark">📘 {{ $taller->titulo }}</h4>
                            <p class="card-text">{{ Str::limit($taller->descripcion, 100) }}</p>
                            <div class="card-actions">
                                @if($taller->materiales)
                                    <a href="{{ asset('storage/' . $taller->materiales) }}" target="_blank"
                                       class="btn btn-solid btn-purple">
                                        <i class="fas fa-file-pdf me-2"></i> Ver Material
                                    </a>
                                @endif
                                <a href="{{ route('talleres.show', $taller) }}"
                                   class="btn btn-solid btn-blue">
                                    <i class="fas fa-book-reader me-2"></i> Ver Secciones
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
