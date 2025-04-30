@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Editar Sección del Taller</h2>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow rounded-4">
                <div class="card-body">
                    <form action="{{ route('secciones.update', $seccion->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la sección</label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $seccion->nombre) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo de sección</label>
                            <select name="tipo" class="form-select" id="tipo-select" required>
                                <option value="lectura" {{ $seccion->tipo === 'lectura' ? 'selected' : '' }}>Lectura</option>
                                <option value="actividad" {{ $seccion->tipo === 'actividad' ? 'selected' : '' }}>Actividad</option>
                                <option value="test" {{ $seccion->tipo === 'test' ? 'selected' : '' }}>Test</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Contenido / Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="4" required>{{ old('descripcion', $seccion->descripcion) }}</textarea>
                        </div>

                        <div class="mb-3" id="opciones-box" style="{{ $seccion->tipo === 'test' ? '' : 'display: none;' }}">
                            <label class="form-label">Opciones del test (una por línea)</label>
                            @php
                                $opciones = is_array($seccion->opciones) ? $seccion->opciones : json_decode($seccion->opciones ?? '[]', true);
                            @endphp
                            @foreach($opciones as $i => $opcion)
                                <div class="input-group mb-2">
                                    <div class="input-group-text">
                                        <input type="radio" name="respuesta_correcta" value="{{ $i }}" {{ $seccion->respuesta_correcta === $opcion ? 'checked' : '' }}>
                                    </div>
                                    <input type="text" name="opciones[]" class="form-control" value="{{ $opcion }}" required>
                                </div>
                            @endforeach
                            @if(empty($opciones))
                                @for($i = 0; $i < 2; $i++)
                                    <div class="input-group mb-2">
                                        <div class="input-group-text">
                                            <input type="radio" name="respuesta_correcta" value="{{ $i }}">
                                        </div>
                                        <input type="text" name="opciones[]" class="form-control" required>
                                    </div>
                                @endfor
                            @endif
                            <small class="text-muted">Marca con el botón la opción correcta.</small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('talleres.edit', $seccion->taller_id) }}" class="btn btn-outline-secondary">← Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('tipo-select').addEventListener('change', function () {
        document.getElementById('opciones-box').style.display = this.value === 'test' ? 'block' : 'none';
    });
</script>
@endsection
