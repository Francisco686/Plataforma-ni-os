@extends('layouts.app')

@section('content')
<!-- Botón de regreso -->
<div class="btn-back" style="position: fixed; top: 1rem; left: 1rem; z-index: 1000;">
    <a href="{{ route('home') }}" class="btn btn-primary btn-md rounded-pill shadow">
        <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
    </a>
</div>

<div class="container py-5 position-relative">
    <!-- Emojis flotantes -->
    <div class="emoji emoji1">🐸</div>
    <div class="emoji emoji2">🧠</div>
    <div class="emoji emoji3">🦋</div>
    <div class="emoji emoji4">🌿</div>

    <!-- Bienvenida destacada -->
    <div class="welcome-box mx-auto text-center p-4 mb-5 animate__animated animate__fadeInDown">
        <h2 class="fw-bold text-success mb-2 display-5">🎮 ¡Bienvenido a la Zona de Juegos!</h2>
        <p class="text-dark fs-5">Explora juegos mágicos que te enseñan a cuidar el planeta 🌎💚</p>
    </div>

    <!-- Tarjetas de Juegos -->
    <div class="row g-5 justify-content-center">
        <!-- Juego 1: Memorama -->
        <div class="col-md-4 col-sm-6">
            <div class="card juego-card text-center shadow-lg animate__animated animate__zoomIn">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="emoji-juego mb-2">🧠</div>
                        <h5 class="fw-bold text-success fs-4">Memorama Ecológico</h5>
                        <p class="text-muted">¡Encuentra los pares de tarjetas ecológicas!</p>
                    </div>
                    <a href="{{ url('/juegos/memorama') }}" class="btn btn-outline-success rounded-pill mt-3">
                        Jugar
                    </a>
                </div>
            </div>
        </div>

        <!-- Juego 2: Sopa de Letras -->
        <div class="col-md-4 col-sm-6">
            <div class="card juego-card text-center shadow-lg animate__animated animate__zoomIn">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="emoji-juego mb-2">🔤✨</div>
                        <h5 class="fw-bold text-primary fs-4">Sopa de Letras</h5>
                        <p class="text-muted">¡Encuentra palabras mágicas sobre la naturaleza!</p>
                    </div>
                    <a href="{{ url('/juegos/sopa') }}" class="btn btn-outline-primary rounded-pill mt-3">
                        Jugar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos -->
<style>
    .welcome-box {
        background: #e0f7ec;
        border: 2px dashed #00c57d;
        border-radius: 1rem;
        box-shadow: 0 0 25px rgba(0, 195, 125, 0.2);
        max-width: 720px;
    }

    .juego-card {
        background: #ffffff;
        border-radius: 1rem;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .juego-card:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 25px rgba(0, 200, 255, 0.25);
    }

    .emoji-juego {
        font-size: 2.7rem;
        animation: bounce 1.5s infinite;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .emoji {
        position: absolute;
        font-size: 2rem;
        opacity: 0.3;
        animation: float 7s ease-in-out infinite;
        z-index: 0;
    }

    .emoji1 { top: 10%; left: 5%; }
    .emoji2 { top: 20%; right: 6%; }
    .emoji3 { bottom: 10%; left: 8%; }
    .emoji4 { bottom: 15%; right: 10%; }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-8px); }
    }

    @media (max-width: 768px) {
        .emoji {
            display: none;
        }

        .welcome-box {
            padding: 2rem 1rem;
        }

        h2.display-5 {
            font-size: 1.8rem;
        }
    }
</style>
<!-- Botón de sonido -->
<div class="text-end me-4 mb-3">
    <button id="toggle-music" class="btn btn-outline-dark">
        🔈 Activar música
    </button>
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
            toggle.innerText = '🔇 Activar música';
        } else {
            music.play();
            toggle.innerText = '🔊 Silenciar música';
        }
        playing = !playing;
    });
</script>


<!-- Animate.css -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
