@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Volver a la lista
    </a>

    <h3 class="mb-4">Editar Alumno</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('alumnos.update', $alumno->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ old('nombre', $alumno->name) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Apellido Paterno</label>
            <input type="text" name="apellido_paterno" value="{{ old('apellido_paterno', $alumno->apellido_paterno) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Apellido Materno</label>
            <input type="text" name="apellido_materno" value="{{ old('apellido_materno', $alumno->apellido_materno) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Contraseña (opcional)</label>
            <input type="text" name="password" class="form-control" placeholder="Deja en blanco si no deseas cambiarla">
        </div>

        <div class="form-group">
            <label for="grado">Grado</label>
            <select name="grado" class="form-control" required>
                <option value="">Selecciona un grado</option>
                @foreach([1,2,3,4,5,6] as $grado)
                    <option value="{{ $grado }}" {{ $alumno->grupo && $alumno->grupo->grado == $grado ? 'selected' : '' }}>
                        {{ $grado }}°
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="grupo">Grupo</label>
            <select name="grupo" class="form-control" required>
                <option value="">Selecciona un grupo</option>
                @foreach(['A','B','C'] as $grupo)
                    <option value="{{ $grupo }}" {{ $alumno->grupo && $alumno->grupo->grupo == $grupo ? 'selected' : '' }}>
                        {{ strtoupper($grupo) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-danger text-white">
    <i class="fas fa-save me-1"></i> Guardar cambios
</button>

    </form>
</div>
@endsection
