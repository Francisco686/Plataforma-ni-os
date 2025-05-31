
@extends('layouts.app')

@section('content')
    <!-- Fondo decorativo -->
    <style>
        body {
            background-image: url('{{ asset("img/fondo2.png") }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>

    <!-- Botón de regreso -->
    <div class="btn-back" style="position: fixed; top: 1rem; left: 1rem; z-index: 1000;">
        <a href="{{ route('home') }}" class="btn btn-primary btn-md rounded-pill shadow animate__animated animate__fadeIn"
           style="font-size: 1.1rem; padding: 0.5rem 1.5rem;">
            <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
        </a>
    </div>

    <!-- Contenido principal -->
    <div class="w-100 position-relative" style="padding: 1rem;">

        <!-- Título -->
        <h2 class="text-center fw-bold mb-5 display-4 text-primary animate__animated animate__pulse"
            style="font-size: 3rem; font-weight: 900;">
            🌱 ¡Explora y aprende!
        </h2>

        <!-- Contenedor de tarjetas -->
        <div class="d-flex flex-wrap justify-content-center">

            <!-- Tarjeta: Taller del Agua -->
            <div class="flex-shrink-0 mx-2" style="width: 280px;">
                <div class="card h-100 border-primary shadow-lg rounded-4 animate__animated animate__zoomIn">
                    <div class="card-body d-flex flex-column justify-content-between p-4 text-center">
                        <img src="{{ asset('img/aguaw.jpg') }}" alt="Agua" class="mb-3" style="height: 120px;">
                        <h5 class="fw-bold text-primary mb-3" style="font-size: 1.7rem;">💧 Taller del Agua</h5>
                        <p style="font-size: 1.2rem;">
                            Este taller incluye <strong>5 sesiones</strong> donde podrás aprender y evaluar tus conocimientos sobre el cuidado del agua.
                        </p>
                        <a href="{{ route('talleres.agua') }}" class="btn btn-outline-primary rounded-pill mt-3">
                            <i class="fas fa-tint me-2"></i> ¡Vamos!
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Taller de Reciclaje -->
            <div class="flex-shrink-0 mx-2" style="width: 280px;">
                <div class="card h-100 border-warning shadow-lg rounded-4 animate__animated animate__zoomIn">
                    <div class="card-body d-flex flex-column justify-content-between p-4 text-center">
                        <img src="{{ asset('img/recicla2.jpg') }}" alt="Reciclaje" class="mb-3" style="height: 120px;">
                        <h5 class="fw-bold text-warning mb-3" style="font-size: 1.7rem;">♻️ Taller de Reciclaje</h5>
                        <p style="font-size: 1.2rem;">
                            Este taller tiene <strong>4 sesiones</strong> donde descubrirás cómo reciclar de forma divertida y evaluarás lo aprendido.
                        </p>
                        <a href="{{ route('talleres.reciclaje') }}" class="btn btn-outline-warning rounded-pill mt-3">
                            <i class="fas fa-recycle me-2"></i> ¡A reciclar!
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta: Taller de Reutilizar -->
            <div class="flex-shrink-0 mx-2" style="width: 280px;">
                <div class="card h-100 border-success shadow-lg rounded-4 animate__animated animate__zoomIn">
                    <div class="card-body d-flex flex-column justify-content-between p-4 text-center">
                        <img src="{{ asset('img/reutilizar2.jpg') }}" alt="Reutilizar" class="mb-3" style="height: 120px;">
                        <h5 class="fw-bold text-success mb-3" style="font-size: 1.7rem;">🔁 Taller de Reutilizar</h5>
                        <p style="font-size: 1.2rem;">
                            Participa en <strong>3 sesiones</strong> donde aprenderás a darle una segunda vida a los objetos y pondrás a prueba tus conocimientos.
                        </p>
                        <a href="{{ route('actividades.reutilizar.index') }}" class="btn btn-outline-success rounded-pill mt-3">
                            <i class="fas fa-sync-alt me-4"></i> ¡Reutilicemos!
                        </a>
                    </div>
                </div>
            </div>

            <!-- Tarjetas dinámicas -->
            @foreach($talleres as $taller)
                <div class="flex-shrink-0 mx-2" style="width: 300px;">
                    <div class="card h-100 border-0 shadow-lg rounded-4 animate__animated animate__fadeInUp">
                        <div class="card-body d-flex flex-column justify-content-between p-4 text-center">
                            <h5 class="fw-bold text-dark mb-3" style="font-size: 1.6rem;">📘 {{ $taller->titulo }}</h5>

                            <p class="text-muted" style="font-size: 1.2rem;">
                                Este taller tiene <strong>{{ $taller->sesiones->count() }} sesiones</strong> en las que podrás aprender y evaluar tus conocimientos.
                            </p>

                            @if($taller->materiales)
                                <a href="{{ asset('storage/' . $taller->materiales) }}" target="_blank"
                                   class="btn btn-outline-secondary rounded-pill my-2">
                                    📄 Ver Material
                                </a>
                            @endif

                            <a href="{{ route('talleres.show', $taller) }}"
                               class="btn btn-outline-primary rounded-pill mt-2">
                                <i class="fas fa-book-reader me-2"></i> Ver Secciones
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <!-- Estilos y animaciones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <style>
        html, body {
            height: auto !important;
            min-height: 100vh;
            overflow-y: auto;
            background-color: #ffffffcc;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .card {
            border: 3px dashed #ddd !important;
            background-color: #ffffffcc;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 0 20px rgba(0, 123, 255, 0.2);
        }

        .btn {
            font-size: 1.1rem;
        }

        .display-4 {
            color: #0d6efd;
            text-shadow: 2px 2px #d0f0ff;
        }

        .btn-back {
            z-index: 1000;
        }

        .d-flex.overflow-auto::-webkit-scrollbar {
            height: 8px;
        }

        .d-flex.overflow-auto::-webkit-scrollbar-thumb {
            background-color: #0d6efd66;
            border-radius: 4px;
        }

        .d-flex.overflow-auto::-webkit-scrollbar-track {
            background-color: transparent;
        }
    </style>
@endsection
