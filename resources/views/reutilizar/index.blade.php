@extends('layouts.nabvar')

@section('content')
    <div class="container">
        <h2 class="mb-4">Secciones del Taller: {{ $taller->nombre }}</h2>

        @if($secciones->isEmpty())
            <p>No hay secciones disponibles.</p>
        @else
            <div class="row">
                @foreach($secciones as $seccion)
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm text-center">
                            {{-- Imagen personalizada por orden (300x200 píxeles) --}}
                            <img
                                src="{{ asset('images/seccion' . $seccion->orden . '.jpg') }}"
                                class="card-img-top mx-auto d-block"
                                alt="Imagen de sección"
                                width="380"
                                height="350"
                                style="object-fit: cover;"
                            >

                            <div class="card-body">
                                <h5 class="card-title">{{ $seccion->nombre }}</h5>
                                <p class="card-text">{{ $seccion->descripcion }}</p>
                                <small class="text-muted">Orden: {{ $seccion->orden }}</small>
                                <br>

                                @if(in_array($seccion->id, $respuestas))
                                    <button class="btn btn-secondary mt-3" disabled>
                                        <i class="fas fa-check mr-1"></i> Completado
                                    </button>
                                @else
                                    <a href="{{ route('seccion.' . $seccion->orden, $seccion->id) }}"
                                       class="btn btn-success mt-3">
                                        <i class="fas fa-play mr-1"></i> Entrar
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
