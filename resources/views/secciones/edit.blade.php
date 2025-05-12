@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4">Editar Sección del Taller: <span class="text-primary">{{ $seccion->taller->titulo }}</span></h2>

        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9">
                <div class="card shadow rounded-4">
                    <div class="card-body">
                        <form action="{{ route('secciones.update', $seccion) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="tipo" class="form-label fw-semibold">Tipo de Sección</label>
                                <select name="tipo" id="tipo" class="form-select" required>
                                    <option value="lectura" {{ $seccion->tipo === 'lectura' ? 'selected' : '' }}>Lectura</option>
                                    <option value="actividad" {{ $seccion->tipo === 'actividad' ? 'selected' : '' }}>Actividad</option>
                                    <option value="test" {{ $seccion->tipo === 'test' ? 'selected' : '' }}>Test (cuestionario)</option>
                                </select>
                                @error('tipo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="titulo" class="form-label fw-semibold">Título de la Sección</label>
                                <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $seccion->titulo) }}" required placeholder="Ej. Introducción al Taller">
                                @error('titulo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="instrucciones-box" style="{{ $seccion->tipo === 'test' ? 'display: none;' : '' }}">
                                <label for="contenido" class="form-label">Contenido / Instrucciones</label>
                                <textarea name="contenido" class="form-control" rows="3" placeholder="Contenido o instrucciones para los alumnos">{{ old('contenido', $seccion->contenido) }}</textarea>
                                @error('contenido')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Contenedor de preguntas (solo visible para tipo test) --}}
                            <div id="preguntas-container" style="{{ $seccion->tipo === 'test' ? 'display: block;' : 'display: none;' }}">
                                <label class="form-label fw-bold">Preguntas del Test</label>

                                @php
                                    $preguntas = $seccion->tipo === 'test' ? json_decode($seccion->opciones, true) : [];
                                @endphp

                                @foreach ($preguntas as $index => $pregunta)
                                    <div class="card mb-3 p-3 shadow-sm rounded border pregunta-item">
                                        <div class="mb-2">
                                            <label class="form-label">Pregunta {{ $index + 1 }}</label>
                                            <input type="text" name="preguntas[{{$index}}][contenido]" class="form-control" value="{{ old('preguntas.' . $index . '.contenido', $pregunta['contenido']) }}" required>
                                            @error('preguntas.' . $index . '.contenido')
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-2 opciones-box">
                                            @foreach ($pregunta['opciones'] as $opcionIndex => $opcion)
                                                <div class="input-group mb-2">
                                                    <div class="input-group-text">
                                                        <input type="radio" name="preguntas[{{$index}}][respuesta_correcta]" value="{{ $opcionIndex }}" {{ old('preguntas.' . $index . '.respuesta_correcta', $pregunta['respuesta_correcta'] === $opcion ? $opcionIndex : '') == $opcionIndex ? 'checked' : '' }} required>
                                                    </div>
                                                    <input type="text" name="preguntas[{{$index}}][opciones][]" class="form-control" value="{{ old('preguntas.' . $index . '.opciones.' . $opcionIndex, $opcion) }}" required>
                                                </div>
                                                @error('preguntas.' . $index . '.opciones.' . $opcionIndex)
                                                <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn btn-outline-secondary btn-sm mb-3" id="add-pregunta" style="{{ $seccion->tipo === 'test' ? 'display: inline-block;' : 'display: none;' }}">
                                + Añadir otra pregunta
                            </button>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('talleres.edit', $seccion->taller) }}" class="btn btn-outline-secondary">← Cancelar</a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Actualizar Sección
                                </button>
                            </div>
                            <small class="text-muted d-block mt-2">Marca la opción correcta en cada pregunta (solo si es tipo test).</small>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let preguntaIndex = {{ count($preguntas) }};

        const tipoSelect = document.getElementById('tipo');
        const preguntasBox = document.getElementById('preguntas-container');
        const instruccionesBox = document.getElementById('instrucciones-box');
        const addBtn = document.getElementById('add-pregunta');

        tipoSelect.addEventListener('change', function () {
            const tipo = this.value;
            if (tipo === 'test') {
                preguntasBox.style.display = 'block';
                addBtn.style.display = 'inline-block';
                instruccionesBox.style.display = 'none';
            } else {
                preguntasBox.style.display = 'none';
                addBtn.style.display = 'none';
                instruccionesBox.style.display = 'block';
            }
        });

        addBtn.addEventListener('click', function () {
            const container = document.getElementById('preguntas-container');

            const card = document.createElement('div');
            card.classList.add('card', 'mb-3', 'p-3', 'shadow-sm', 'rounded', 'border', 'pregunta-item');

            let contenido = `
            <div class="mb-2">
                <label class="form-label">Pregunta ${preguntaIndex + 1}</label>
                <input type="text" name="preguntas[${preguntaIndex}][contenido]" class="form-control" placeholder="Escribe la pregunta" required>
            </div>
            <div class="mb-2 opciones-box">
        `;

            for (let i = 0; i < 2; i++) {
                contenido += `
                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <input type="radio" name="preguntas[${preguntaIndex}][respuesta_correcta]" value="${i}" required>
                    </div>
                    <input type="text" name="preguntas[${preguntaIndex}][opciones][]" class="form-control" required placeholder="Opción ${i + 1}">
                </div>
            `;
            }

            contenido += `</div>`;
            card.innerHTML = contenido;
            container.appendChild(card);
            preguntaIndex++;
        });
    </script>
@endsection
