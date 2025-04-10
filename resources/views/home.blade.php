@extends('layouts.customHome') 

@section('content')
<div class="container mt-5" style="background-image: url('{{ asset('img/fondo.png') }}'); background-size: cover; background-position: center; height: 100vh;">
    <div class="row justify-content-center" style="height: 100%;">
        <div class="col-md-10" style="display: flex; flex-direction: column; justify-content: center;">
            <div class="card shadow-none p-0 rounded" style="background-color: rgba(255, 255, 255, 0); border: none;">
                <div class="card-body text-center" style="background-color: rgba(255, 255, 255, 0); border: none;">
                    <!-- Texto en blanco y negritas -->
                    <h1 class="text-white font-weight-bold"><strong>¡Bienvenido, {{ Auth::user()->name }}!</strong></h1>
                    <p class="lead text-white"><strong>Explora tu plataforma de aprendizaje interactiva.</strong></p>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <div class="card bg-success text-white text-center p-3" style="background-color: rgba(0, 128, 0, 0.5); border: none;">
                                <i class="fas fa-book fa-3x mb-2"></i>
                                <h4>Mis talleres</h4>
                                <p>Accede a tus talleres y consulta tu progreso.</p>
                                <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm">Ir</a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-warning text-white text-center p-3" style="background-color: rgba(255, 165, 0, 0.5); border: none;">
                                <i class="fas fa-edit fa-3x mb-2"></i>
                                <h4>Evaluaciones</h4>
                                <p>Responde actividades y mejora tus calificaciones.</p>
                                <a href="#" class="btn btn-light btn-sm">Ir</a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card bg-info text-white text-center p-3" style="background-color: rgba(0, 191, 255, 0.5); border: none;">
                                <i class="fas fa-gamepad fa-3x mb-2"></i>
                                <h4>Zona de Juegos</h4>
                                <p>Aprende mientras te diviertes con juegos educativos.</p>
                                <a href="#" class="btn btn-light btn-sm">Ir</a>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card bg-primary text-white text-center p-3" style="background-color: rgba(0, 0, 255, 0.5); border: none;">
                                <i class="fas fa-star fa-3x mb-2"></i>
                                <h4>Mis Logros</h4>
                                <p>Descubre tus insignias y premios obtenidos.</p>
                                <a href="#" class="btn btn-light btn-sm">Ver</a>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-danger text-white text-center p-3" style="background-color: rgba(255, 0, 0, 0.5); border: none;">
                                <i class="fas fa-comments fa-3x mb-2"></i>
                                <h4>Foro</h4>
                                <p>Comparte dudas y opiniones con compañeros y maestros.</p>
                                <a href="#" class="btn btn-light btn-sm">Ir</a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <a href="{{ route('logout') }}" class="btn btn-dark btn-lg"
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
    </div>
</div>
@endsection
