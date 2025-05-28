@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-success">👩‍🏫 Bienvenido Docente</h2>
        <p class="text-muted">Aquí puedes gestionar alumnos y evaluar su progreso.</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-5 mb-4">
            <a href="{{ route('alumnos.index') }}" class="btn btn-success btn-lg w-100">
                📋 Registrar Alumnos
            </a>
        </div>
        <div class="col-md-5 mb-4">
            <a href="{{ route('evaluaciones.index') }}" class="btn btn-primary btn-lg w-100">
                📊 Ver Evaluaciones
            </a>
        </div>
    </div>
</div>
@endsection
