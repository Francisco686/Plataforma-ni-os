@extends('layouts.app')

@section('content')
    <!-- Botón fuera del contenedor interno -->
    <div class="btn-back" style="position: fixed; top: 1rem; left: 1rem; z-index: 1000;">
        <a href="{{ route('home') }}" onclick="console.log('Botón Regresar clicado')" class="btn btn-primary btn-md rounded-pill shadow animate__animated animate__fadeIn" style="font-size: 1.1rem; padding: 0.5rem 1.5rem; pointer-events: auto;">
            <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
        </a>
    </div>

    <div class="w-100 position-relative" style="padding: 1rem;">
        <!-- Título -->
        <h2 class="text-center fw-bold mb-4 mb-md-5 display-4 text-primary animate__animated animate__fadeInDown"
            style="font-size: 3rem; font-weight: 700;">
            Mis Talleres
        </h2>

        <!-- Cuadrícula de tarjetas -->
        @forelse($talleres as $index => $taller)
            @if($index % 4 === 0)
                <div class="row g-5 mb-5 mb-md-3">
                    @endif

                    <div class="col-md-3 col-12">
                        <div class="card h-100 shadow-lg border-0 rounded-4 animate__animated animate__fadeInUp">
                            <div class="card-body d-flex flex-column justify-content-between p-4">
                                <div class="mb-4">
                                    <h5 class="fw-bold text-dark mb-3" style="font-size: 1.7rem;">{{ $taller->titulo }}</h5>
                                    <p class="text-dark" style="font-size: 1.3rem;">{{ Str::limit($taller->descripcion, 100) }}</p>
                                </div>

                                <div class="d-flex flex-column gap-2 ">
                                    @if($taller->materiales)
                                        <a href="{{ asset('storage/' . $taller->materiales) }}" target="_blank"
                                           class="btn btn-outline-success rounded-pill w-100 text-start px-3 py-2" style=" font-size: 1.1rem;">
                                            <i class="fas fa-file-alt me-2"></i> Ver Material
                                        </a>
                                    @else
                                        <span class="badge bg-warning text-dark py-2 px-3 align-self-center" style="font-size: 1rem;">Sin material</span>
                                    @endif

                                    <a href="{{ route('talleres.show', $taller) }}"
                                       class="btn btn-outline-primary rounded-pill w-100 text-start px-3 py-2" style="font-size: 1.1rem;">
                                        <i class="fas fa-tasks me-2"></i> Ver Secciones
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>

                    @if($index % 4 === 3 || $loop->last)
                </div>
            @endif
        @empty
            <div class="row g-5 mb-5">
                <div class="col-12">
                    <div class="alert alert-info animate__animated animate__fadeIn p-4">
                        <h4 class="fw-bold mb-3" style="font-size: 1.6rem;">¡Aún no tienes talleres asignados!</h4>
                        <p class="mb-0" style="font-size: 1.2rem;">Espera a que tu maestro te asigne nuevos talleres para comenzar a aprender.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Animaciones -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <style>
        /* Asegurar que el cuerpo permita scroll */
        html, body {
            height: auto !important;
            min-height: 100vh;
            overflow-y: auto !important;
            margin: 0;
            padding: 0;
        }

        /* Forzar un contenedor dinámico con efecto de blur en layouts.app */
        .contenido-centro {
            max-width: 1400px !important;
            height: auto !important;
            padding: 3rem !important;
            width: 100% !important;
            margin: 0 auto !important;
            position: static !important;
            transform: none !important;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.2) !important;
            -webkit-backdrop-filter: blur(25px);
            backdrop-filter: blur(25px);
            border-radius: 1rem;
            pointer-events: auto !important;
        }

        /* Ajustar contenido */
        .w-100, .row, .card, .alert, .btn {
            max-width: 100%;
            margin-left: 0;
            margin-right: 0;
            padding-left: 0;
            padding-right: 0;
            box-sizing: border-box;
        }

        /* Estilo de las tarjetas */
        .card {
            min-height: 250px;
            max-height: 400px;
            transition: transform 0.2s;
            background-color: #fff !important;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        /* Estilo del botón */
        .btn-back, .btn-back a {
            pointer-events: auto !important;
        }

        /* Ajustar tamaños en móviles */
        @media (max-width: 576px) {
            .contenido-centro {
                max-width: 95% !important;
                padding: 1rem !important;
                height: auto !important;
            }
            .display-4 {
                font-size: 2rem;
            }
            .card-title {
                font-size: 1.3rem;
            }
            .card-text, .btn, .alert h4, .alert p {
                font-size: 1rem;
            }
            .card {
                min-height: 200px;
                max-height: 350px;
            }
            .row {
                margin-bottom: 2rem !important;
            }
            .row.g-5 {
                gap: 1rem !important;
            }
        }

        @media (max-width: 768px) {
            .contenido-centro {
                max-width: 90% !important;
                padding: 1.5rem !important;
                height: auto !important;
            }
            .row {
                margin-bottom: 2.5rem !important;
            }
            .row.g-5 {
                gap: 1.5rem !important;
            }
        }
    </style>
@endsection
