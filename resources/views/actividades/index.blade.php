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
        @if(auth()->user() && auth()->user()->role === 'alumno')
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
        @endif

        /* --- Estilos compartidos --- */
        h2 {
            font-size: 3.5rem;
            color: #0d6efd;
            font-weight: 900;
            text-shadow: 2px 2px #d0f0ff;
            margin-bottom: 2rem;
            text-align: center;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        h5 {
            font-size: 1.6rem;
            font-weight: 700;
            text-shadow: 1px 1px #d0f0ff;
            margin-bottom: 0.8rem;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .game-card {
            border-radius: 1.8rem;
            background: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            border: 2px solid #0d6efd;
            padding: 1.5rem;
            width: 100%;
            max-width: 500px;
            height: 560px;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .game-card:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 12px 30px rgba(0, 123, 255, 0.4);
        }

        .card-body {
            display: flex;
            flex-direction: column;
            height: 100%;
            padding-bottom: 2rem;
        }

        .card-img-top {
            width: 100%;
            height: 180px;
            object-fit: cover;
            margin: 0.8rem auto;
            border-radius: 1rem;
            border: 3px solid #e9ecef;
        }

        .card-text {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 1rem;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            min-height: 160px;
            flex: 1;
        }

        .card-actions {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
            align-items: center;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .btn-solid {
            color: #fff;
            font-weight: 600;
            padding: 0.7rem 1.8rem;
            border-radius: 0.8rem;
            border: none;
            transition: all 0.3s ease;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            width: 100%;
            max-width: 300px;
            text-align: center;
            font-size: 1rem;
        }

        .btn-green {
            background-color: #22c55e;
        }
        .btn-green:hover {
            background-color: #15803d;
            transform: translateY(-1px);
        }

        .btn-blue {
            background-color: #0d6efd;
        }
        .btn-blue:hover {
            background-color: #0a58ca;
            transform: translateY(-1px);
        }

        .btn-back {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 1000;
        }

        .btn-create-container {
            position: fixed;
            top: 6rem;
            left: 1.5rem;
            z-index: 1000;
        }

        .cards-container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 3rem;
        }

        .fixed-cards-container {
            display: flex;
            flex-wrap: nowrap;
            justify-content: center;
            gap: 3rem;
        }

        .dynamic-cards-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 3rem;
        }

        .alert-success {
            border-radius: 12px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            text-align: center;
            margin: 1rem auto;
            max-width: 500px;
            font-size: 0.95rem;
        }

        @if(auth()->user() && auth()->user()->isDocente())
            .btn-create {
            width: 100%;
            max-width: 300px;
            padding: 0.7rem 1.8rem;
            font-size: 1rem;
            border-radius: 0.8rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-create:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
        }
        @endif

        @media (max-width: 768px) {
            h2 {
                font-size: 2.5rem;
            }

            h5 {
                font-size: 1.4rem;
            }

            .game-card {
                max-width: 380px;
                height: 520px;
                padding: 1.2rem;
            }

            .card-img-top {
                height: 140px;
            }

            .card-text {
                font-size: 1.1rem;
                min-height: 120px;
            }

            .card-actions {
                margin-top: 1rem;
                margin-bottom: 0.8rem;
            }

            .btn-solid {
                font-size: 0.9rem;
                padding: 0.6rem 1.5rem;
                max-width: 280px;
            }

            .btn-create-container {
                top: 5.5rem;
            }

            .fixed-cards-container {
                flex-direction: column;
                align-items: center;
                gap: 2rem;
            }

            .dynamic-cards-container {
                flex-direction: column;
                align-items: center;
                gap: 2rem;
            }

            @if(auth()->user() && auth()->user()->isDocente())
                .btn-create {
                max-width: 300px;
            }
        @endif
}
    </style>

    <!-- Fondo animado SOLO para alumnos -->
    @if(auth()->user() && auth()->user()->role === 'alumno')
        <div class="background-animated">
            <div class="balloon"></div>
            <div class="balloon"></div>
            <div class="balloon"></div>
            <div class="balloon"></div>
            <div class="emoji emoji1">🎮</div>
            <div class="emoji emoji2">🧩</div>
            <div class="emoji emoji3">🔤</div>
            <div class="emoji emoji4">♻️</div>
        </div>
    @endif

    <div class="container-fluid py-5" style="min-height: 100vh; position: relative; z-index: 1;">
        <!-- Botón de regreso -->
        <div class="btn-back">
            <a href="{{ route('home') }}" class="btn btn-solid btn-green animate__animated animate__fadeIn">
                <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
            </a>
        </div>

        <!-- Botón Crear Nueva Sesión (solo docentes) -->
        @if(auth()->user() && auth()->user()->isDocente())
            <div class="btn-create-container">
                <a href="{{ route('actividades.create') }}" class="btn btn-solid btn-blue btn-create animate__animated animate__fadeIn">
                    <i class="fas fa-plus me-2"></i> Crear Nueva Sesión
                </a>
            </div>
        @endif

        <!-- Título -->
        <h2 class="animate__animated animate__pulse">🌱 ¡Explora y aprende!</h2>

        @if(session('success'))
            <div class="alert alert-success animate__animated animate__fadeIn text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Contenedor de tarjetas -->
        <div class="cards-container">
            <!-- Tarjetas fijas -->
            <div class="fixed-cards-container">
                <!-- Taller fijo: Agua -->
                <div class="game-card animate__animated animate__zoomIn">
                    <div class="card-body text-center">
                        <img src="{{ asset('img/aguaw.jpg') }}" alt="Agua" class="card-img-top">
                        <h5 class="text-primary">💧 Taller del Agua</h5>
                        <p class="card-text">
                            Este taller incluye <strong>5 sesiones</strong> donde podrás aprender y evaluar tus conocimientos sobre el cuidado del agua.
                        </p>
                        <div class="card-actions">
                            <a href="{{ route('actividades.actividades', ['tallerId' => 1]) }}" class="btn btn-solid btn-green">
                                <i class="fas fa-tint me-2"></i> ¡Vamos!
                            </a>
                            <div style="height: 38px;"></div> <!-- Espacio para igualar botones -->
                        </div>
                    </div>
                </div>

                <!-- Taller fijo: Reciclaje -->
                <div class="game-card animate__animated animate__zoomIn">
                    <div class="card-body text-center">
                        <img src="{{ asset('img/recicla2.jpg') }}" alt="Reciclaje" class="card-img-top">
                        <h5 class="text-warning">♻️ Taller de Reciclaje</h5>
                        <p class="card-text">
                            Este taller tiene <strong>4 sesiones</strong> donde descubrirás cómo reciclar de forma divertida y evaluarás lo aprendido.
                        </p>
                        <div class="card-actions">
                            <a href="{{ route('actividades.actividades', ['tallerId' => 2]) }}" class="btn btn-solid btn-green">
                                <i class="fas fa-recycle me-2"></i> ¡A reciclar!
                            </a>
                            <div style="height: 38px;"></div> <!-- Espacio para igualar botones -->
                        </div>
                    </div>
                </div>

                <!-- Taller fijo: Reutilizar -->
                <div class="game-card animate__animated animate__zoomIn">
                    <div class="card-body text-center">
                        <img src="{{ asset('img/reutilizar2.jpg') }}" alt="Reutilizar" class="card-img-top">
                        <h5 class="text-success">🔁 Taller de Reutilizar</h5>
                        <p class="card-text">
                            Participa en <strong>3 sesiones</strong> donde aprenderás a darle una segunda vida a los objetos y pondrás a prueba tus conocimientos.
                        </p>
                        <div class="card-actions">
                            <a href="{{ route('actividades.actividades', ['tallerId' => 3]) }}" class="btn btn-solid btn-green">
                                <i class="fas fa-sync-alt me-2"></i> ¡Reutilicemos!
                            </a>
                            <div style="height: 38px;"></div> <!-- Espacio para igualar botones -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tarjetas dinámicas -->
            <div class="dynamic-cards-container">
                @foreach($talleres as $taller)
                    <div class="game-card animate__animated animate__zoomIn">
                        <div class="card-body text-center">
                            <h5 class="text-dark">📘 {{ $taller->titulo }}</h5>
                            <p class="card-text">
                                Este taller tiene <strong>{{ $taller->sesiones->count() }} sesiones</strong> en las que podrás aprender y evaluar tus conocimientos.
                            </p>
                            <div class="card-actions">
                                @if($taller->materiales)
                                    <a href="{{ asset('storage/' . $taller->materiales) }}" target="_blank"
                                       class="btn btn-solid btn-green">
                                        <i class="fas fa-file-pdf me-2"></i> Ver Material
                                    </a>
                                @else
                                    <div style="height: 38px;"></div> <!-- Espacio para igualar botones -->
                                @endif
                                <a href="{{ route('talleres.show', $taller) }}"
                                   class="btn btn-solid btn-green">
                                    <i class="fas fa-book-reader me-2"></i> Ver Secciones
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
