@extends('layouts.customHome')

@section('content')
    <style>
        body {
            background: linear-gradient(to bottom, #c6f3ff, #ffffff);
            overflow-x: hidden;
            position: relative;
        }

        /* --- Fondo y animaciones SOLO para alumnos --- */
        @if(Auth::user()->role === 'alumno')
    .background-animated {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .balloon {
            position: absolute;
            width: 40px; height: 60px;
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            animation: floatUp 8s linear infinite;
        }
        .balloon::after {
            content: '';
            position: absolute;
            bottom: -20px; left: 50%;
            width: 2px; height: 20px;
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
            font-size: 2.2rem;
            opacity: 0.4;
            animation: float 8s ease-in-out infinite;
        }
        .emoji1 { top: 10%; left: 8%; }
        .emoji2 { top: 20%; right: 10%; }
        .emoji3 { bottom: 15%; left: 12%; }
        .emoji4 { bottom: 8%; right: 15%; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }
        @endif

/* --- Estilos compartidos --- */
        .username-drop {
            animation: dropDown 1s ease-out forwards;
            transform: translateY(-100px);
            opacity: 0;
        }
        @keyframes dropDown { to { transform: translateY(0); opacity: 1; } }

        .card {
            border-radius: 1.2rem;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 1px solid #eee;
            padding: 2.5rem 1.5rem;
            min-height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
        .card .icon {
            font-size: 4rem;
            margin-bottom: 1.2rem;
        }

        /* Botones sólidos */
        .btn-solid {
            color: #fff !important;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            border-radius: 0.8rem;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-green { background-color: #22c55e; }
        .btn-green:hover { background-color: #15803d; }

        .btn-blue { background-color: #3b82f6; }
        .btn-blue:hover { background-color: #1e40af; }

        .btn-yellow { background-color: #eab308; }
        .btn-yellow:hover { background-color: #a16207; }

        .btn-purple { background-color: #8b5cf6; }
        .btn-purple:hover { background-color: #5b21b6; }

        .btn-dark {
            background-color: #111827;
            color: white;
        }
        .btn-dark:hover {
            background-color: #000;
        }

        /* Tamaños de texto */
        h1 { font-size: 3.8rem !important; }
        h4 { font-size: 1.6rem !important; }
        p.lead, .fs-4 { font-size: 1.4rem !important; }

        /* Responsivo */
        @media (max-width: 768px) {
            .emoji, .balloon { display: none; }
            h1 { font-size: 2.4rem !important; }
            h4 { font-size: 1.3rem !important; }
        }
    </style>

    <!-- Fondo animado SOLO alumnos -->
    @if(Auth::user()->role === 'alumno')
        <div class="background-animated">


            <div class="emoji emoji1">🦊</div>
            <div class="emoji emoji2">🧸</div>
            <div class="emoji emoji3">🦋</div>
            <div class="emoji emoji4">🐸</div>
        </div>
    @endif

    <div class="container-lg px-3 px-md-5 position-relative" style="z-index: 1;">
        <div class="row justify-content-center" style="min-height: 100vh; padding-top: 3rem;">
            <div class="col-12 text-center">

                <!-- Bienvenida -->
                <h1 class="fw-bold mb-3 username-drop text-primary">
                    ¡Hola {{ strtoupper(Auth::user()->name) }}!
                </h1>

                <!-- Grupo alumno -->
                @if(Auth::user()->role === 'alumno' && Auth::user()->grupo)
                    <div class="d-flex justify-content-center">
                        <div class="px-5 py-3 fs-4 fw-bold text-white rounded-pill shadow-lg mb-4"
                             style="background: linear-gradient(90deg,#4f46e5,#6366f1,#818cf8);">
                            📚 Tu grupo es:
                            <span class="text-warning">
                        {{ Auth::user()->grupo->grado }}°{{ strtoupper(Auth::user()->grupo->grupo) }}
                    </span>
                        </div>
                    </div>
                @endif

                {{-- Vista Alumno --}}
                @if(Auth::user()->role === 'alumno')
                    <p class="lead text-dark mb-5 mt-3">
                        ¡Explora tus talleres, juegos y logros mágicos! 🌟🧠
                    </p>

                    <div class="row g-4 justify-content-center">
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="icon">📚</div>
                                <h4 class="fw-bold">Mis Talleres</h4>
                                <a href="{{ route('talleres.index') }}" class="btn btn-solid btn-green mt-3">Ir</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="icon">🎮</div>
                                <h4 class="fw-bold">Juegos</h4>
                                <a href="{{ route('juegos.index') }}" class="btn btn-solid btn-blue mt-3">Ir</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="icon">🏅</div>
                                <h4 class="fw-bold">Mis Logros</h4>
                                <a href="{{ route('logros.index') }}" class="btn btn-solid btn-purple mt-3">Ver</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-center">
                                <div class="icon">📝</div>
                                <h4 class="fw-bold">Actividades</h4>
                                <a href="{{ route('actividades1.index') }}" class="btn btn-solid btn-yellow mt-3">Explorar</a>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Vista Docente --}}
                @if(Auth::user()->role === 'docente')
                    <div class="container-fluid px-3 px-md-5 mt-5">
                        <p class="lead text-dark mb-5">
                            Bienvenido docente. Gestiona alumnos y consulta evaluaciones.
                        </p>

                        <div class="row g-4 justify-content-center">
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="icon">👥</div>
                                    <h4 class="fw-bold">Registrar Alumnos</h4>
                                    <a href="{{ route('alumnos.index') }}" class="btn btn-solid btn-green mt-3">Acceder</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="icon">📊</div>
                                    <h4 class="fw-bold">Evaluaciones</h4>
                                    <a href="{{ route('evaluaciones.index') }}" class="btn btn-solid btn-blue mt-3">Ver</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="icon">📝</div>
                                    <h4 class="fw-bold">Actividades</h4>
                                    <a href="{{ route('actividades1.index') }}" class="btn btn-solid btn-yellow mt-3">Ver</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Botón salir -->
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
