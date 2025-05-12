@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Registrar Alumno</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('alumnos.store') }}">
        @csrf

        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="apellido_paterno">Apellido Paterno</label>
            <input type="text" name="apellido_paterno" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="apellido_materno">Apellido Materno</label>
            <input type="text" name="apellido_materno" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="text" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="grado">Grado</label>
            <select name="grado" id="grado" class="form-control" required>
                <option value="">Selecciona un grado</option>
                @foreach([1,2,3,4,5,6] as $grado)
                    <option value="{{ $grado }}">{{ $grado }}°</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="grupo">Grupo</label>
            <select name="grupo" id="grupo" class="form-control" required>
                <option value="">Selecciona un grupo</option>
                @foreach(['A','B','C'] as $grupo)
                    <option value="{{ $grupo }}">{{ strtoupper($grupo) }}</option>
                @endforeach
            </select>
        </div>

        <div class="d-flex justify-content-end mt-4 gap-2">
    <a href="{{ route('alumnos.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Cancelar
    </a>

    <button type="submit" class="btn btn-danger text-white">
        <i class="fas fa-save me-1"></i> Guardar
    </button>
</div>


    </form>
</div>
@endsection
