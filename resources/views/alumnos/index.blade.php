@extends('layouts.app')

@section('content')
<div class="container">
    <a href="{{ route('home') }}" class="btn btn-outline-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Volver al inicio
    </a>

    <h3 class="mb-4">Lista de Alumnos</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('alumnos.create') }}" class="btn btn-primary">
            <i class="fas fa-user-plus me-1"></i> Registrar Alumno
        </a>

        @if(Auth::user()->isDocente())
        <a href="{{ route('evaluaciones.index') }}" class="btn btn-danger text-white">
    <i class="fas fa-clipboard-check me-1"></i> Evaluaciones
</a>

        @endif
    </div>

    @if(Auth::user()->isDocente())
        <form method="POST" action="{{ route('user.cambiarGrupo') }}" class="mb-3">
            @csrf
            <div class="form-group">
                <label for="grupo_id">Selecciona tu grupo:</label>
                <select name="grupo_id" id="grupo_id" class="form-control" onchange="this.form.submit()">
                    @foreach($grupos as $grupo)
                        <option value="{{ $grupo->id }}" {{ Auth::user()->grupo_id == $grupo->id ? 'selected' : '' }}>
                            {{ $grupo->grado }}°{{ strtoupper($grupo->grupo) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </form>
    @endif

    <table class="table table-bordered table-hover text-center">
        <thead class="thead-light">
            <tr>
                <th>(Accede con este nombre a la plataforma)</th>
                <th>Grupo</th>
                <th>Contraseña</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->name }}</td>
                    <td>
                        @if ($alumno->grupo)
                            {{ $alumno->grupo->grado }}°{{ strtoupper($alumno->grupo->grupo) }}
                        @else
                            No asignado
                        @endif
                    </td>
                    <td>{{ $alumno->password_visible }}</td>
                    <td class="text-center">
                        <a href="{{ route('alumnos.show', $alumno->id) }}" class="btn btn-info btn-sm" title="Ver información del alumno">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-warning btn-sm" title="Editar información del alumno">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('alumnos.destroy', $alumno->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" title="Eliminar alumno" onclick="return confirm('¿Eliminar alumno?')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
