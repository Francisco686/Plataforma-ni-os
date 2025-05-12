<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Plataforma Interactiva</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap y Animate.css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar-custom {
            background-color: rgba(0, 128, 0, 0.9);
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: white;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .navbar-custom .nav-link:hover {
            color: #ffd700;
        }

        main {
            padding-top: 80px;
        }
    </style>

    @yield('styles')
</head>
<body>

<!-- Barra de navegación superior -->
<nav class="navbar navbar-expand-lg navbar-custom fixed-top shadow">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ url('/home') }}">
            <i class="fas fa-home me-2"></i>Inicio
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon text-white"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                @auth
                    {{-- Alumno --}}
                    @if(Auth::user()->isAlumno())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('talleres.index') }}">
                                <i class="fas fa-book me-1"></i> Mis Talleres
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-star me-1"></i> Logros
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-comments me-1"></i> Foro
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-gamepad me-1"></i> Zona de Juegos
                            </a>
                        </li>
                    @endif

                    {{-- Docente --}}
                    @if(Auth::user()->isDocente())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('evaluaciones.index') }}">
                                <i class="fas fa-edit me-1"></i> Evaluaciones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('alumnos.index') }}">
                                <i class="fas fa-users me-1"></i> Mis Alumnos
                            </a>
                        </li>
                    @endif

                    {{-- Administrador --}}
                    @if(Auth::user()->role === 'administrador')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('talleres.index') }}">
                                <i class="fas fa-tools me-1"></i> Talleres
                            </a>
                        </li>
                    @endif

                    {{-- Cerrar sesión --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endauth

            </ul>
        </div>
    </div>
</nav>

<!-- Contenido -->
<main>
    @yield('content')
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
