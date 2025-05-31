@extends('layouts.customHome')

@section('content')
    <style>
        body {
            background: linear-gradient(to bottom, #c6f3ff, #ffffff);
            overflow-x: hidden;
            position: relative;
        }

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

        .username-drop {
            animation: dropDown 1s ease-out forwards;
            transform: translateY(-100px);
            opacity: 0;
        }

        @keyframes dropDown {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .balloon {
            position: absolute;
            width: 40px;
            height: 60px;
            background: radial-gradient(circle, #ff8eb8, #f14a72);
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            animation: floatUp 6s linear infinite;
        }

        .balloon::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 50%;
            width: 2px;
            height: 20px;
            background: #888;
            transform: translateX(-50%);
        }

        .balloon:nth-child(1) { left: 10%; animation-delay: 0s; }
        .balloon:nth-child(2) { left: 30%; animation-delay: 2s; background: #a4cafe; }
        .balloon:nth-child(3) { left: 70%; animation-delay: 1s; background: #ffd166; }
        .balloon:nth-child(4) { left: 85%; animation-delay: 3s; background: #8ecae6; }

        @keyframes floatUp {
            0% { bottom: -100px; opacity: 0.8; }
            100% { bottom: 110%; opacity: 0; }
        }

        .card {
            border-radius: 1rem;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border: 2px solid transparent;
        }

        .card:hover {
            transform: scale(1.05);
            border-color: #00c3ff;
            box-shadow: 0 0 25px rgba(0, 195, 255, 0.6);
        }

        .card .icon {
            font-size: 2.5rem;
            margin-bottom: 0.8rem;
        }

        .emoji {
            position: absolute;
            font-size: 2rem;
            opacity: 0.5;
            animation: float 8s ease-in-out infinite;
        }

        .emoji1 { top: 10%; left: 8%; }
        .emoji2 { top: 20%; right: 10%; }
        .emoji3 { bottom: 15%; left: 12%; }
        .emoji4 { bottom: 8%; right: 15%; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        @media (max-width: 768px) {
            .emoji, .balloon {
                display: none;
            }

            .card .icon {
                font-size: 2rem;
            }
        }
    </style>

    <!-- Fondo animado -->
    <div class="background-animated">
        <div class="balloon"></div>
        <div class="balloon"></div>
        <div class="balloon"></div>
        <div class="balloon"></div>

        <div class="emoji emoji1">🦊</div>
        <div class="emoji emoji2">🧸</div>
        <div class="emoji emoji3">🦋</div>
        <div class="emoji emoji4">🐸</div>
    </div>

    <div class="container-fluid px-3 px-md-5 position-relative" style="z-index: 1;">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-12 text-center">
                <h1 class="fw-bold mb-3 username-drop" style="font-size: 3rem; color: #0d6efd;">
                    🎉 ¡Hola {{ strtoupper(Auth::user()->name) }}!
                </h1>

                @if(Auth::user()->role === 'alumno' && Auth::user()->grupo)
                    <div class="alert alert-info shadow rounded-pill d-inline-block px-4 py-2 fs-5 mt-3">
                        📚 Tu grupo es: <strong>{{ Auth::user()->grupo->grado }}°{{ strtoupper(Auth::user()->grupo->grupo) }}</strong>
                    </div>
                @endif

                {{-- Para alumnos --}}
                @if(Auth::user()->role === 'alumno')
                    <p class="lead text-dark mb-5 fs-4 mt-4">
                        ¡Explora tus talleres, juegos y logros mágicos! 🌟🧠
                    </p>

                    <div class="row g-4 justify-content-center animate__animated animate__fadeInUp">
                        <div class="col-md-3">
                            <div class="card text-center p-4">
                                <div class="icon">📚</div>
                                <h4 class="fw-bold">Mis Talleres</h4>
                                <a href="{{ route('talleres.index') }}" class="btn btn-outline-success mt-3">Ir</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center p-4">
                                <div class="icon">🎮</div>
                                <h4 class="fw-bold">Juegos</h4>
                                <a href="{{ route('juegos.index') }}" class="btn btn-outline-info mt-3">Ir</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center p-4">
                                <div class="icon">🏅</div>
                                <h4 class="fw-bold">Mis Logros</h4>
                                <a href="{{ route('logros.index') }}" class="btn btn-outline-primary mt-3">Ver</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center p-4">
                                <div class="icon">📝</div>
                                <h4 class="fw-bold">Actividades</h4>
                                <a href="{{ route('actividades1.index') }}" class="btn btn-outline-warning mt-3">Explorar</a>
                            </div>
                        </div>
                    </div>
                @endif




                @if(Auth::user()->role === 'docente')
                    <div class="container-fluid px-3 px-md-5 position-relative mt-5">
                        <div class="row justify-content-center">
                            <div class="col-12 text-center">
                                <p class="lead text-dark fs-4 mb-4">
                                    Bienvenido docente. Gestiona alumnos y consulta evaluaciones. 👨‍🏫📊
                                </p>

                                <div class="row g-4 justify-content-center animate__animated animate__fadeInUp">
                                    <div class="col-md-4">
                                        <div class="card text-center p-4">
                                            <div class="icon">👥</div>
                                            <h4 class="fw-bold">Registrar Alumnos</h4>
                                            <a href="{{ route('alumnos.index') }}" class="btn btn-outline-success mt-3">Acceder</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center p-4">
                                            <div class="icon">📊</div>
                                            <h4 class="fw-bold">Evaluaciones</h4>
                                            <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline-primary mt-3">Ver</a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card text-center p-4">
                                            <div class="icon">📝</div>
                                            <h4 class="fw-bold">Actividades</h4>
                                            <a href="{{ route('actividades1.index') }}" class="btn btn-outline-primary mt-3">Ver</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="mt-5">
                    <a href="{{ route('logout') }}" class="btn btn-dark btn-lg px-4"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("click", () => {
            const audio = document.getElementById("bienvenidaAudio");
            if (audio && audio.paused) {
                audio.play().catch(() => {});
            }
        }, { once: true });
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
