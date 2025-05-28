@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #fef6e4);
        font-family: 'Segoe UI', sans-serif;
    }

    .pantalla-completa {
        min-height: 100vh;
        background: white;
        border-radius: 1rem;
        padding: 3rem 2rem;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
    }

    h3 {
        color: #0d6efd;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #198754;
        border: none;
    }

    .btn-primary:hover {
        background-color: #157347;
    }

    .btn-danger {
        background-color: #dc3545;
        border: none;
    }

    .btn-danger:hover {
        background-color: #bb2d3b;
    }

    .table thead {
        background-color: #d1ecf1;
        color: #0c5460;
        font-weight: bold;
        font-size: 1.05rem;
    }

    .table td {
        color: #212529;
        font-size: 1rem;
        vertical-align: middle !important;
    }

    .table td:first-child {
        font-weight: 600;
    }

    .form-group label {
        font-weight: bold;
    }

    .alert {
        font-size: 1rem;
    }

    .btn-outline-secondary {
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .table {
            font-size: 0.9rem;
        }

        .btn, .form-control {
            font-size: 0.9rem;
        }

        h3 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container-fluid d-flex justify-content-center align-items-start py-5" style="background: linear-gradient(to right, #e0f7fa, #fef6e4); min-height: 100vh;">
    <div class="col-lg-10 pantalla-completa">
        <a href="{{ route('home') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Volver al inicio
        </a>

        <h3 class="mb-4">📋 Lista de Alumnos</h3>

        <p class="text-muted mt-2">
            👥 Total de alumnos en este grupo: <strong>{{ $total }}</strong>
        </p>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="d-flex justify-content-between mb-3 flex-wrap gap-2">
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
            <form method="POST" action="{{ route('user.cambiarGrupo') }}" class="mb-4">
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

        <div class="table-responsive">
            <table class="table table-bordered table-hover text-center">
                <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
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
                            <td>
                                <a href="{{ route('alumnos.show', $alumno->id) }}" class="btn btn-info btn-sm" title="Ver información">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('alumnos.edit', $alumno->id) }}" class="btn btn-warning btn-sm" title="Editar">
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
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
