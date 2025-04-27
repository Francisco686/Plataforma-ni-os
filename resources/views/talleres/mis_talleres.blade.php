@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center fw-bold mb-5 display-4 text-primary animate__animated animate__fadeInDown">
        Mis Talleres
    </h2>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="row g-4">
                @forelse($talleres as $taller)
                    <div class="col-md-6 col-xl-4">
                        <div class="card h-100 shadow-lg border-0 rounded-4 animate__animated animate__fadeInUp">
                            <div class="card-body d-flex flex-column justify-content-between text-center">
                                <div>
                                    <h5 class="card-title text-success fw-bold mb-3">{{ $taller->titulo }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($taller->descripcion, 100) }}</p>
                                </div>

                                <div class="mt-3 d-grid gap-2">
                                    @if($taller->materiales)
                                        <a href="{{ asset('storage/' . $taller->materiales) }}" target="_blank"
                                           class="btn btn-outline-success btn-sm rounded-pill">
                                            <i class="fas fa-file-alt me-2"></i> Ver Material
                                        </a>
                                    @else
                                        <span class="badge bg-warning text-dark">Sin material</span>
                                    @endif

                                    <a href="{{ route('talleres.show', $taller) }}"
                                       class="btn btn-outline-primary btn-sm rounded-pill">
                                        <i class="fas fa-tasks me-2"></i> Ver Secciones
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center animate__animated animate__fadeIn">
                            <h4 class="fw-bold mb-3">¡Aún no tienes talleres asignados!</h4>
                            <p class="mb-0">Espera a que tu maestro te asigne nuevos talleres para comenzar a aprender.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Botón regresar --}}
    <div class="text-center mt-5">
        <a href="{{ route('home') }}" class="btn btn-primary btn-lg rounded-pill shadow animate__animated animate__fadeInUp">
            <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
        </a>
    </div>
</div>

{{-- Animaciones --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
@endsection
