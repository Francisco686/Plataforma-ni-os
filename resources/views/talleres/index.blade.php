@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center text-primary mb-4">Mis Talleres</h2>

    <div class="row justify-content-center">
        @forelse($talleres as $t)
            @php
                $secciones = $t->secciones;
                $total = $secciones->count();

                $completadas = 0;

                foreach ($secciones as $sec) {
                    $progreso = \App\Models\ProgresoTaller::where('seccion_taller_id', $sec->id)
                        ->whereHas('asignacion', function($q) use($userId) {
                            $q->where('user_id', $userId);
                        })
                        ->where('completado', true)
                        ->first();

                    if ($progreso) $completadas++;
                }

                $porcentaje = $total > 0 ? round(($completadas / $total) * 100) : 0;
            @endphp

            <div class="col-md-4 mb-4">
                <div class="card border-info shadow-sm h-100">
                    <div class="card-body text-center">
                        <h4 class="card-title text-success font-weight-bold">{{ $t->nombre }}</h4>
                        <p class="card-text">{{ $t->descripcion }}</p>

                        <div class="progress mb-2" style="height: 20px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $porcentaje }}%;">
                                {{ $porcentaje }}%
                            </div>
                        </div>

                        <a href="{{ route('talleres.ver', $t->id) }}" class="btn btn-outline-primary mt-2">
                            Entrar al Taller
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center">No hay talleres disponibles.</p>
        @endforelse
    </div>
</div>
@endsection
