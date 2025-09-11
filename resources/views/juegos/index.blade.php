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
        h1 {
            font-size: 4.5rem;
            color: #0d6efd;
            font-weight: 900;
            text-shadow: 3px 3px #d0f0ff;
            margin-bottom: 3rem;
            text-align: center;
            animation: pulse 2s infinite;
        }
        h4 {
            font-size: 2.2rem;
            font-weight: 700;
            text-shadow: 1px 1px #d0f0ff;
            margin-bottom: 1.5rem;
        }
        .card {
            border-radius: 2rem;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            padding: 3rem;
            width: 100%;
        }
        .card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0, 123, 255, 0.3);
        }
        .card-text {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.2rem;
        }
        .btn-solid {
            color: #fff;
            font-weight: 600;
            padding: 0.9rem 2.2rem;
            border-radius: 1.2rem;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-green { background-color: #22c55e; }
        .btn-green:hover { background-color: #15803d; transform: translateY(-2px); }
        .btn-blue { background-color: #3b82f6; }
        .btn-blue:hover { background-color: #1e40af; transform: translateY(-2px); }
        .btn-yellow { background-color: #eab308; }
        .btn-yellow:hover { background-color: #a16207; transform: translateY(-2px); }
        .btn-dark { background-color: #343a40; }
        .btn-dark:hover { background-color: #1a1e21; transform: translateY(-2px); }
        .btn-back {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 1000;
        }
        .btn-music {
            position: fixed;
            top: 1.5rem;
            right: 1.5rem;
            z-index: 1000;
        }
        .emoji-juego {
            font-size: 2.7rem;
            margin-bottom: 1rem;
        }
        .emoji-juego.bounce {
            animation: bounce 1.5s ease-in-out 1;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .section-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }
        @media (max-width: 768px) {
            h1 {
                font-size: 3rem;
            }
            h4 {
                font-size: 1.8rem;
            }
            .card {
                padding: 2rem;
            }
            .card-text {
                font-size: 1.3rem;
            }
            .btn-solid {
                font-size: 1.1rem;
                padding: 0.7rem 1.8rem;
            }
            .emoji-juego {
                font-size: 2rem;
            }
            .section-container {
                padding: 0 1rem;
            }
            .emoji {
                display: none;
            }
        }
    </style>
    <!-- Fondo animado SOLO para alumnos -->
    @if(Auth::user()->role === 'alumno')
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
    <!-- Botón de sonido -->
    <div class="btn-music">
        <button id="toggle-music" class="btn btn-solid btn-dark animate__animated animate__fadeIn">
            🔈 Activar música
        </button>
    </div>
    <div class="container-fluid py-5" style="min-height: 100vh; position: relative; z-index: 1;">
        <!-- Botón de regreso -->
        <div class="btn-back">
            <a href="{{ route('home') }}" class="btn btn-solid btn-green animate__animated animate__fadeIn">
                <i class="fas fa-arrow-left me-2"></i> Regresar a Inicio
            </a>
        </div>
        <!-- Título -->
        <h1 class="animate__animated animate__pulse">🎮 Zona de Juegos</h1>
        @if(session('success'))
            <div class="alert alert-success animate__animated animate__fadeIn text-center" style="max-width: 600px; margin: 1rem auto;">
                {{ session('success') }}
            </div>
        @endif
        <!-- Sección: Juegos -->
        <section class="section-container animate__animated animate__fadeInUp">
            <div class="row g-4">
                <!-- Juego 1: Memorama Ecológico -->
                <div class="col-md-3 col-sm-6 d-flex">
                    <div class="card text-center shadow-lg w-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <div class="emoji-juego">🧠</div>
                                <h5 class="fw-bold text-success fs-4">Memorama Ecológico</h5>
                                <p class="card-text">¡Encuentra los pares de tarjetas ecológicas!</p>
                            </div>
                            <a href="{{ url('/juegos/memorama') }}" class="btn btn-solid btn-green mt-3">Jugar</a>
                        </div>
                    </div>
                </div>
                <!-- Juego 2: Sopa de Letras -->
                <div class="col-md-3 col-sm-6 d-flex">
                    <div class="card text-center shadow-lg w-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <div class="emoji-juego">🔤</div>
                                <h5 class="fw-bold text-primary fs-4">Sopa de Letras</h5>
                                <p class="card-text">¡Encuentra palabras sobre la naturaleza!</p>
                            </div>
                            <a href="{{ url('/juegos/sopa') }}" class="btn btn-solid btn-blue mt-3">Jugar</a>
                        </div>
                    </div>
                </div>
                <!-- Juego 3: Combinaciones -->
                <div class="col-md-3 col-sm-6 d-flex">
                    <div class="card text-center shadow-lg w-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <div class="emoji-juego">🧩</div>
                                <h5 class="fw-bold text-warning fs-4">Combinaciones</h5>
                                <p class="card-text">¡Combina materiales para crear objetos!</p>
                            </div>
                            <a href="{{ route('juegos.combinar') }}" class="btn btn-solid btn-yellow mt-3">Jugar</a>
                        </div>
                    </div>
                </div>
                <!-- Juego 4: Clasificación de residuos -->
                <div class="col-md-3 col-sm-6 d-flex">
                    <div class="card text-center shadow-lg w-100 d-flex flex-column">
                        <div class="card-body d-flex flex-column justify-content-between p-4">
                            <div>
                                <div class="emoji-juego">♻️</div>
                                <h5 class="fw-bold text-success fs-4">Clasificación de residuos</h5>
                                <p class="card-text">¡Arrastra objetos a los botes correctos!</p>
                            </div>
                            <a href="{{ route('juegos.clasificacion') }}" class="btn btn-solid btn-green mt-3">Jugar</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Audio oculto -->
    <audio id="background-music" src="{{ asset('audio/bienvenida.mp3') }}" loop></audio>
    <script>
        const music = document.getElementById('background-music');
        const toggle = document.getElementById('toggle-music');
        let playing = false;
        toggle.addEventListener('click', () => {
            if (playing) {
                music.pause();
                toggle.innerText = '🔈 Activar música';
            } else {
                music.play();
                toggle.innerText = '🔊 Silenciar música';
            }
            playing = !playing;
        });
        // Random emoji-juego animation trigger
        document.addEventListener('DOMContentLoaded', () => {
            const emojis = document.querySelectorAll('.emoji-juego');
            const minDelay = 20000; // 20 seconds in milliseconds
            const maxDelay = 30000; // 30 seconds in milliseconds
            function triggerBounce(emoji) {
                emoji.classList.add('bounce');
                // Remove bounce class after animation completes (1.5s)
                setTimeout(() => {
                    emoji.classList.remove('bounce');
                }, 1500);
                // Schedule next bounce with random delay
                setTimeout(() => triggerBounce(emoji), Math.random() * (maxDelay - minDelay) + minDelay);
            }
            emojis.forEach(emoji => {
                // Initial random delay to stagger start
                setTimeout(() => triggerBounce(emoji), Math.random() * (maxDelay - minDelay) + minDelay);
            });
        });
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
