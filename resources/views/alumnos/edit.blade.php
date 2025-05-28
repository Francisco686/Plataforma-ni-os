@extends('layouts.app')

@section('content')
<style>
    .fondo-editar {
        min-height: 100vh;
        background: linear-gradient(to right, #e0f7fa, #fff9c4);
        padding: 3rem 1rem;
        display: flex;
        justify-content: center;
    }

    .editar-container {
        background: white;
        border-radius: 20px;
        padding: 2rem 2.5rem;
        max-width: 700px;
        width: 100%;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
    }

    h3 {
        color: #0d6efd;
        font-weight: bold;
        text-align: center;
    }

    label {
        font-weight: bold;
        color: #198754;
    }

    .form-control {
        margin-bottom: 1rem;
        border-radius: 10px;
    }

    .btn-danger {
        background-color: #e63946;
        border: none;
        font-weight: bold;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }
</style>

<div class="fondo-editar">
    <div class="editar-container">
        <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Volver a la lista
        </a>

        <h3 class="mb-4">✏️ Editar Alumno</h3>

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
                <label>Grado</label>
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
                <label>Grupo</label>
                <select name="grupo" class="form-control" required>
                    <option value="">Selecciona un grupo</option>
                    @foreach(['A','B','C'] as $grupo)
                        <option value="{{ $grupo }}" {{ $alumno->grupo && $alumno->grupo->grupo == $grupo ? 'selected' : '' }}>
                            {{ strtoupper($grupo) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-danger text-white">
                    <i class="fas fa-save me-1"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
