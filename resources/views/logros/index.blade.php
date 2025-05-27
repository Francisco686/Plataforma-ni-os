@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Botón de regreso -->
    <div class="mb-3">
        <a href="{{ route('home') }}" class="btn btn-primary rounded-pill shadow">
            <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
        </a>
    </div>

    <h2 class="text-center mb-4">🏅 Mis Logros</h2>

    @if($logros->isEmpty())
        <div class="alert alert-info text-center">
            Aún no has conseguido ningún logro... ¡sigue jugando!
        </div>
    @else
        <div class="row justify-content-center">
            @foreach($logros as $logro)
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card shadow-sm text-center h-100">
                        <img src="{{ asset($logro->icono) }}" class="card-img-top p-3" style="height: 150px; object-fit: contain;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $logro->nombre }}</h5>
                            <p class="card-text text-muted small">{{ $logro->descripcion }}</p>
                            <small class="text-success">Obtenido: {{ \Carbon\Carbon::parse($logro->pivot->fecha_obtenido)->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
