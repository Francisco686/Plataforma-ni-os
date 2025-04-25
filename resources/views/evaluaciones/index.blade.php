@extends('layouts.nabvar')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4 text-center text-primary">Evaluación de Alumnos</h2>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-success">
                <tr>
                    <th>Alumno</th>
                    <th>Grupo</th>
                    <th>Taller</th>
                    <th>Progreso</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumnos as $alumno)
                    @foreach($alumno->talleresAsignados as $asignacion)
                        @php
                            $taller = $asignacion->taller;
                            $total = $taller->secciones->count();
                            $completadas = $asignacion->progresos->where('completado', true)->count();
                            $porcentaje = $total > 0 ? round(($completadas / $total) * 100) : 0;
                        @endphp
                        <tr>
                            <td>{{ $alumno->name }}</td>
                            <td>
                                {{ $alumno->grupo->grado ?? '-' }}{{ $alumno->grupo->grupo ?? '' }}
                            </td>
                            <td>{{ $taller->nombre }}</td>
                            <td>
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar bg-info" role="progressbar"
                                         style="width: {{ $porcentaje }}%;">
                                        {{ $porcentaje }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
