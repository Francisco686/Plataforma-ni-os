@extends('layouts.app')

@section('content')

    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #fef6e4);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .pantalla-completa {
            min-height: 100vh;
            background: white;
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin: 1rem;
        }

        h3 {
            color: #0d6efd;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 1.5rem;
        }

        .btn {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
            font-weight: 600;
            padding: 0.5rem 1rem;
        }

        .btn-primary {
            background-color: #198754;
            border: none;
        }

        .btn-primary:hover {
            background-color: #157347;
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #bb2d3b;
            transform: translateY(-1px);
        }

        .btn-info {
            background-color: #0dcaf0;
            border: none;
            color: white;
        }

        .btn-info:hover {
            background-color: #0bb4d3;
            transform: translateY(-1px);
        }

        .btn-warning {
            background-color: #ffc107;
            border: none;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            border-color: #6c757d;
            color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        .table-container {
            background: white;
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
        }

        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background-color: #e3f2fd;
            color: #0c5460;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .table th, .table td {
            padding: 1rem;
            vertical-align: middle;
            border: none;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr {
            transition: background-color 0.2s ease;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .table tbody tr:hover {
            background-color: #e9ecef;
        }

        .table td:first-child {
            font-weight: 600;
            color: #343a40;
        }

        .form-group label {
            font-weight: 600;
            font-size: 0.95rem;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
        }

        .alert {
            border-radius: 0.5rem;
            font-size: 0.95rem;
            padding: 0.75rem 1.25rem;
        }

        .filtros {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
            background: #f1f3f5;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
        }

        .filtros .form-group {
            flex: 1;
            min-width: 160px;
        }

        .btn-group-actions {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .btn-group-actions .btn {
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
        }

        .top-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            .pantalla-completa {
                padding: 1.5rem;
                margin: 0.5rem;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th, .table td {
                padding: 0.75rem;
            }

            .btn, .form-control {
                font-size: 0.85rem;
            }

            .h3 {
                font-size: 1.8rem;
            }

            .filtros .form-group {
                min-width: 100%;
            }

            .btn-group-actions {
                flex-direction: column;
                gap: 0.3rem;
            }
        }
    </style>

    <div class="container-fluid d-flex justify-content-center align-items-start py-5" style="background: linear-gradient(to right, #e0f7fa, #fef6e4); min-height: 100vh;">
        <div class="col-lg-10 pantalla-completa">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary mb-4">
                <i class="fas fa-arrow-left me-1"></i> Volver al inicio
            </a>

            <h3 class="mb-4"><i class="fas fa-users me-2"></i>Lista de Alumnos</h3>

            <p class="text-muted mb-3">
                <i class="fas fa-user-friends me-1"></i> Total de alumnos: <strong>{{ $total }}</strong>
            </p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="top-buttons">
                <a href="{{ route('alumnos.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-1"></i> Registrar Alumno
                </a>

                @if(Auth::user()->isDocente())
                    <a href="{{ route('evaluaciones.index') }}" class="btn btn-danger">
                        <i class="fas fa-clipboard-check me-1"></i> Evaluaciones
                    </a>
                @endif
            </div>

            <!-- Filtros y buscador -->
            <form method="GET" action="{{ route('alumnos.index') }}" class="filtros">
                <div class="form-group">
                    <label for="grado">Grado</label>
                    <select name="grado" id="grado" class="form-control" onchange="this.form.submit()">
                        <option value="">Todos los grados</option>
                        @foreach($grados as $grado)
                            <option value="{{ $grado }}" {{ request('grado') == $grado ? 'selected' : '' }}>
                                {{ $grado }}°
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="grupo">Grupo</label>
                    <select name="grupo" id="grupo" class="form-control" onchange="this.form.submit()">
                        <option value="">Todos los grupos</option>
                        @foreach($letras as $letra)
                            <option value="{{ strtoupper($letra) }}" {{ request('grupo') == strtoupper($letra) ? 'selected' : '' }}>
                                {{ strtoupper($letra) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group flex-grow-1">
                    <label for="search">Buscar</label>
                    <div class="input-group">
                        <input type="text" name="search" id="search" class="form-control" placeholder="Buscar alumno..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>

            <!-- Tabla de alumnos -->
            <div class="table-container">
                <table class="table table-hover text-center">
                    <thead>
                    <tr>
                        <th>Nombre de Usuario</th>
                        <th>Grupo</th>
                        <th>Contraseña</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($alumnos as $alumno)
                        <tr>
                            <td>{{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}, {{ $alumno->name }}</td>
                            <td>
                                @if ($alumno->grupo)
                                    {{ $alumno->grupo->grado }}°{{ strtoupper($alumno->grupo->grupo) }}
                                @else
                                    <span class="text-muted">No asignado</span>
                                @endif
                            </td>
                            <td>{{ $alumno->password_visible }}</td>
                            <td>
                                <div class="btn-group-actions">
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
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-muted py-3">No se encontraron alumnos.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
