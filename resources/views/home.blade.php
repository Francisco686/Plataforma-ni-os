@extends('layouts.customHome')

@section('content')
    <div class="container-fluid p-0 home-background" style="background-size: cover; background-position: center; min-height: 100vh; margin: 0; padding: 0;">
        <div class="row no-gutters" style="height: 100vh; margin: 0;">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div style="width: 95%; max-width: 1200px;">
                    <div class="text-center">
                        <!-- Texto de bienvenida con animación -->
                        <div class="animate_animated animate_fadeInDown">
                            <h1 class="text-white font-weight-bold mb-3"><strong>¡Bienvenido, {{ Auth::user()->name }}!</strong></h1>
                            <p class="lead text-white mb-5"><strong>Explora tu plataforma de aprendizaje interactiva.</strong></p>
                        </div>

                        <!-- Primera fila de tarjetas -->
                        <div class="row mt-4">
                            @if(Auth::user()->role === 'administrador')
                                <!-- Tarjeta para Administradores (Talleres) -->
                                <div class="col-md-4 mb-4 animate_animated animatefadeInLeft animate_fast">
                                    <div class="card card-hover bg-success text-white text-center p-3 h-100" style="background-color: rgba(0, 128, 0, 0.7); border: none; border-radius: 15px; transition: all 0.3s ease;">
                                        <i class="fas fa-tools fa-3x mb-2 icon-animate book-animate"></i>
                                        <h4>Gestión de Talleres</h4>
                                        <p>Administra todos los talleres disponibles.</p>
                                        <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm mt-auto">Administrar</a>
                                    </div>
                                </div>
                            @else
                                <!-- Tarjeta para otros roles (Mis Talleres) -->
                                <div class="col-md-4 mb-4 animate_animated animatefadeInLeft animate_fast">
                                    <div class="card card-hover bg-success text-white text-center p-3 h-100" style="background-color: rgba(0, 128, 0, 0.7); border: none; border-radius: 15px; transition: all 0.3s ease;">
                                        <i class="fas fa-book fa-3x mb-2 icon-animate book-animate"></i>
                                        <h4>Mis talleres</h4>
                                        <p>Accede a tus talleres y consulta tu progreso.</p>
                                        <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm mt-auto">Ir</a>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-4 mb-4 animate_animated animatefadeInUp animate_fast">
                                <div class="card card-hover bg-warning text-white text-center p-3 h-100" style="background-color: rgba(255, 165, 0, 0.7); border: none; border-radius: 15px; transition: all 0.3s ease;">
                                    <i class="fas fa-edit fa-3x mb-2 icon-animate pencil-animate"></i>
                                    <h4>Evaluaciones</h4>
                                    <p>Responde actividades y mejora tus calificaciones.</p>
                                    <a href="#" class="btn btn-light btn-sm mt-auto">Ir</a>
                                </div>
                            </div>

                            <div class="col-md-4 mb-4 animate_animated animatefadeInRight animate_fast">
                                <div class="card card-hover bg-info text-white text-center p-3 h-100" style="background-color: rgba(0, 191, 255, 0.7); border: none; border-radius: 15px; transition: all 0.3s ease;">
                                    <i class="fas fa-gamepad fa-3x mb-2 icon-animate gamepad-animate"></i>
                                    <h4>Zona de Juegos</h4>
                                    <p>Aprende mientras te diviertes con juegos educativos.</p>
                                    <a href="#" class="btn btn-light btn-sm mt-auto">Ir</a>
                                </div>
                            </div>
                        </div>

                        <!-- Segunda fila de tarjetas -->
                        <div class="row">

                            <!-- Tarjeta para otros roles (Mis Logros) -->
                            <div class="col-md-6 mb-4 animate_animated animatefadeInLeft animate_fast">
                                <div class="card card-hover bg-primary text-white text-center p-3 h-100" style="background-color: rgba(0, 0, 255, 0.7); border: none; border-radius: 15px; transition: all 0.3s ease;">
                                    <i class="fas fa-star fa-3x mb-2 icon-animate star-animate"></i>
                                    <h4>Mis Logros</h4>
                                    <p>Descubre tus insignias y premios obtenidos.</p>
                                    <a href="#" class="btn btn-light btn-sm mt-auto">Ver</a>
                                </div>
                            </div>


                            <div class="col-md-6 mb-4 animate_animated animatefadeInRight animate_fast">
                                <div class="card card-hover bg-danger text-white text-center p-3 h-100" style="background-color: rgba(255, 0, 0, 0.7); border: none; border-radius: 15px; transition: all 0.3s ease;">
                                    <i class="fas fa-comments fa-3x mb-2 icon-animate comments-animate"></i>
                                    <h4>Foro</h4>
                                    <p>Comparte dudas y opiniones con compañeros y maestros.</p>
                                    <a href="#" class="btn btn-light btn-sm mt-auto">Ir</a>
                                </div>
                            </div>
                        </div>

                        <!-- Botón de cerrar sesión con animación -->
                        <div class="mt-5 animate_animated animate_fadeInUp">
                            <a href="{{ route('logout') }}" class="btn btn-dark btn-lg btn-hover"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                               style="transition: all 0.3s ease;">
                                <i class="fas fa-sign-out-alt icon-animate logout-animate"></i> Cerrar Sesión
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

    <!-- Incluir Animate.css para las animaciones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        /* Efecto hover para las tarjetas */
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Efecto hover para el botón */
        .btn-hover:hover {
            transform: scale(1.05);
        }

        /* Animación de fondo sutil */
        .home-background {
            animation: subtleBackground 15s infinite alternate;
        }

        @keyframes subtleBackground {
            0% {
                background-position: center;
            }
            100% {
                background-position: 20% center;
            }
        }

        /* Mejoras de espaciado */
        .card {
            padding: 25px 15px !important;
        }

        .card h4 {
            margin-bottom: 15px;
        }

        .card p {
            margin-bottom: 20px;
        }

        /* Animaciones personalizadas para iconos */
        .icon-animate {
            transition: all 0.5s ease;
        }

        .book-animate {
            animation: bookFlip 3s infinite ease-in-out;
        }

        .pencil-animate {
            animation: pencilWrite 2s infinite alternate;
        }

        .gamepad-animate {
            animation: gamepadVibrate 1.5s infinite;
        }

        .star-animate {
            animation: starPulse 2s infinite alternate;
        }

        .comments-animate {
            animation: speechBubble 2.5s infinite ease-in-out;
        }

        .logout-animate {
            animation: rotateLogout 4s infinite linear;
        }

        @keyframes bookFlip {
            0%, 100% { transform: rotateY(0deg); }
            50% { transform: rotateY(20deg); }
        }

        @keyframes pencilWrite {
            0% { transform: rotate(0deg) translateX(0); }
            100% { transform: rotate(5deg) translateX(5px); }
        }

        @keyframes gamepadVibrate {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px) rotate(-5deg); }
            75% { transform: translateX(3px) rotate(5deg); }
        }

        @keyframes starPulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.2); opacity: 1; text-shadow: 0 0 10px gold; }
        }

        @keyframes speechBubble {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes rotateLogout {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection
