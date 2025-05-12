@extends('layouts.customHome')

@section('content')
    <div class="container-fluid p-0 home-background" style="background-size: cover; background-position: center; min-height: 100vh; margin: 0; padding: 0;">
        <div class="row no-gutters" style="min-height: 100vh; margin: 0;">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="w-100 px-3 px-md-5"> <!-- Cambiado a w-100 con padding responsivo -->
                    <div class="text-center">
                        <div class="animate_animated animate_fadeInDown">
                            <h1 class="text-white font-weight-bold mb-3"><strong>¡Bienvenid@, {{ Auth::user()->name }}!</strong></h1>

                            @if(Auth::user()->role === 'alumno' && Auth::user()->grupo)
                                <div class="alert alert-info text-center mb-4">
                                    Tu grupo es: <strong>{{ Auth::user()->grupo->grado }}°{{ strtoupper(Auth::user()->grupo->grupo) }}</strong>
                                </div>
                            @endif

                            <p class="lead text-white mb-5"><strong>Explora tu plataforma de aprendizaje interactiva.</strong></p>
                        </div>

                        <div class="row g-4 mt-4"> <!-- Ajustado con gutter para mejor espaciado -->

                            @if(Auth::user()->role === 'administrador')
                                <div class="col-12 col-md-6 col-lg-4 mb-4"> <!-- Ajustado para pantallas grandes -->
                                    <div class="card card-hover bg-success text-white text-center p-4 h-100">
                                        <i class="fas fa-tools fa-3x mb-2 icon-animate"></i>
                                        <h4>Gestión de Talleres</h4>
                                        <p>Administra todos los talleres disponibles.</p>
                                        <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm mt-auto">Administrar</a>
                                    </div>
                                </div>
                            @endif

                            @if(Auth::user()->isDocente())
                                <div class="row g-4"> <!-- Contenedor row con gutter -->
                                    <!-- Tarjeta 1 -->
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card border-0 shadow-sm h-100 bg-info text-white">
                                            <div class="card-body p-4 d-flex flex-column">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-tools fa-3x me-3"></i>
                                                    <h5 class="card-title mb-0">Talleres</h5>
                                                </div>
                                                <p class="card-text flex-grow-1">Crea y asigna talleres educativos a tus alumnos.</p>
                                                <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm align-self-start mt-2">
                                                    Administrar <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tarjeta 2 -->
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card border-0 shadow-sm h-100 bg-warning text-white">
                                            <div class="card-body p-4 d-flex flex-column">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-clipboard-list fa-3x me-3"></i>
                                                    <h5 class="card-title mb-0">Evaluaciones</h5>
                                                </div>
                                                <p class="card-text flex-grow-1">Monitorea el progreso de tus estudiantes.</p>
                                                <a href="{{ route('evaluaciones.index') }}" class="btn btn-light btn-sm align-self-start mt-2">
                                                    Ver <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tarjeta 3 -->
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="card border-0 shadow-sm h-100 bg-danger text-white">
                                            <div class="card-body p-4 d-flex flex-column">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-user-plus fa-3x me-3"></i>
                                                    <h5 class="card-title mb-0">Alumnos</h5>
                                                </div>
                                                <p class="card-text flex-grow-1">Gestiona el registro y grupos de alumnos.</p>
                                                <a href="{{ route('alumnos.index') }}" class="btn btn-light btn-sm align-self-start mt-2">
                                                    Administrar <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(Auth::user()->role === 'alumno')
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <div class="card card-hover bg-success text-white text-center p-4 h-100">
                                        <i class="fas fa-book fa-3x mb-2 icon-animate"></i>
                                        <h4>Mis Talleres</h4>
                                        <p>Accede a tus talleres y consulta tu progreso.</p>
                                        <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm mt-auto">Ir</a>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <div class="card card-hover bg-info text-white text-center p-4 h-100">
                                        <i class="fas fa-gamepad fa-3x mb-2 icon-animate"></i>
                                        <h4>Zona de Juegos</h4>
                                        <p>Aprende mientras te diviertes con juegos educativos.</p>
                                        <a href="{{ route('juegos.index') }}" class="btn btn-light btn-sm mt-auto">Ir</a>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <div class="card card-hover bg-primary text-white text-center p-4 h-100">
                                        <i class="fas fa-star fa-3x mb-2 icon-animate"></i>
                                        <h4>Mis Logros</h4>
                                        <p>Descubre tus insignias y premios obtenidos.</p>
                                        <a href="#" class="btn btn-light btn-sm mt-auto">Ver</a>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="mt-5 animate_animated animate_fadeInUp">
                            <a href="{{ route('logout') }}" class="btn btn-dark btn-lg btn-hover"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt icon-animate"></i> Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2); }
        .btn-hover:hover { transform: scale(1.05); }
        .home-background { animation: subtleBackground 15s infinite alternate; }
        @keyframes subtleBackground { 0% { background-position: center; } 100% { background-position: 20% center; } }
        .card { padding: 25px 15px !important; }
        .card h4 { margin-bottom: 15px; }
        .card p { margin-bottom: 20px; }
        .icon-animate { transition: all 0.5s ease; }
        .book-animate { animation: bookFlip 3s infinite ease-in-out; }
        .pencil-animate { animation: pencilWrite 2s infinite alternate; }
        .gamepad-animate { animation: gamepadVibrate 1.5s infinite; }
        .star-animate { animation: starPulse 2s infinite alternate; }
        .logout-animate { animation: rotateLogout 4s infinite linear; }

        @keyframes bookFlip { 0%, 100% { transform: rotateY(0deg); } 50% { transform: rotateY(20deg); } }
        @keyframes pencilWrite { 0% { transform: rotate(0deg) translateX(0); } 100% { transform: rotate(5deg) translateX(5px); } }
        @keyframes gamepadVibrate { 0%, 100% { transform: translateX(0); } 25% { transform: translateX(-3px) rotate(-5deg); } 75% { transform: translateX(3px) rotate(5deg); } }
        @keyframes starPulse { 0% { transform: scale(1); opacity: 0.8; } 100% { transform: scale(1.2); opacity: 1; text-shadow: 0 0 10px gold; } }
        @keyframes rotateLogout { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    </style>
@endsection
