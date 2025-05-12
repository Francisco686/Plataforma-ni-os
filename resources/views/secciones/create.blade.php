@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="text-center mb-4">Agregar Sección al Taller: <span class="text-primary">{{ $taller->titulo }}</span></h2>

        <p class="text-center text-muted">ID del Taller: {{ $taller->id }}</p>


        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9">
                <div class="card shadow rounded-4">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('secciones.store', $taller) }}" method="POST">
                            @csrf
                            <input type="hidden" name="taller_id" value="{{ $taller->id }}">
                            <div class="mb-3">
                                <label for="tipo" class="form-label fw-semibold">Tipo de Sección</label>
                                <select name="tipo" id="tipo" class="form-select" required>
                                    <option value="" disabled selected>Selecciona un tipo</option>
                                    <option value="lectura" {{ old('tipo') === 'lectura' ? 'selected' : '' }}>Lectura</option>
                                    <option value="actividad" {{ old('tipo') === 'actividad' ? 'selected' : '' }}>Actividad</option>
                                    <option value="test" {{ old('tipo') === 'test' ? 'selected' : '' }}>Test (cuestionario)</option>
                                </select>
                                @error('tipo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="titulo" class="form-label fw-semibold">Título de la Sección</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" value="{{ old('titulo') }}" required placeholder="Ej. Introducción al Taller">
                                @error('titulo')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="instrucciones-box">
                                <label for="contenido" class="form-label">Contenido / Instrucciones</label>
                                <textarea name="contenido" id="contenido" class="form-control" rows="3" placeholder="Contenido o instrucciones para los alumnos">{{ old('contenido') }}</textarea>
                                @error('contenido')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="preguntas-container" style="display: none;">
                                <label class="form-label fw-bold">Preguntas del Test</label>
                                <div class="card mb-3 p-3 shadow-sm rounded border pregunta-item">
                                    <div class="mb-2">
                                        <label class="form-label">Pregunta 1</label>
                                        <input type="text" name="preguntas[0][contenido]" class="form-control pregunta-contenido" value="{{ old('preguntas.0.contenido') }}" placeholder="Escribe la pregunta">
                                        @error('preguntas.0.contenido')
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-2 opciones-box">
                                        @for($i = 0; $i < 2; $i++)
                                            <div class="input-group mb-2">
                                                <div class="input-group-text">
                                                    <input type="radio" name="preguntas[0][respuesta_correcta]" value="{{ $i }}" class="pregunta-opcion" {{ old('preguntas.0.respuesta_correcta') == $i ? 'checked' : '' }}>
                                                </div>
                                                <input type="text" name="preguntas[0][opciones][]" class="form-control pregunta-opcion" value="{{ old('preguntas.0.opciones.' . $i) }}" placeholder="Opción {{ $i + 1 }}">
                                            </div>
                                            @error('preguntas.0.opciones.' . $i)
                                            <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        @endfor
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-secondary btn-sm mb-3" id="add-pregunta" style="display: none;">
                                + Añadir otra pregunta
                            </button>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('talleres.edit', $taller) }}" class="btn btn-outline-secondary">← Cancelar</a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Guardar Sección
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
        let preguntaIndex = 1;

        const tipoSelect = document.getElementById('tipo');
        const preguntasBox = document.getElementById('preguntas-container');
        const instruccionesBox = document.getElementById('instrucciones-box');
        const addBtn = document.getElementById('add-pregunta');
        const contenidoTextarea = document.getElementById('contenido');

        function updateFormVisibility() {
            const tipo = tipoSelect.value;
            if (tipo === 'test') {
                preguntasBox.style.display = 'block';
                addBtn.style.display = 'inline-block';
                instruccionesBox.style.display = 'none';
                // Hacer los campos de test requeridos
                document.querySelectorAll('.pregunta-contenido, .pregunta-opcion').forEach(input => input.required = true);
                contenidoTextarea.required = false;
                contenidoTextarea.value = ''; // Limpiar contenido para test
            } else {
                preguntasBox.style.display = 'none';
                addBtn.style.display = 'none';
                instruccionesBox.style.display = 'block';
                // Hacer el campo contenido opcional
                document.querySelectorAll('.pregunta-contenido, .pregunta-opcion').forEach(input => input.required = false);
                contenidoTextarea.required = false; // Opcional, ya que la validación es nullable
            }
        }

        tipoSelect.addEventListener('change', updateFormVisibility);

        // Ejecutar al cargar la página para reflejar el estado inicial
        updateFormVisibility();

        addBtn.addEventListener('click', function () {
            const container = document.getElementById('preguntas-container');

            const card = document.createElement('div');
            card.classList.add('card', 'mb-3', 'p-3', 'shadow-sm', 'rounded', 'border', 'pregunta-item');

            let contenido = `
            <div class="mb-2">
                <label class="form-label">Pregunta ${preguntaIndex + 1}</label>
                <input type="text" name="preguntas[${preguntaIndex}][contenido]" class="form-control pregunta-contenido" placeholder="Escribe la pregunta" required>
            </div>
            <div class="mb-2 opciones-box">
        `;

            for (let i = 0; i < 2; i++) {
                contenido += `
                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <input type="radio" name="preguntas[${preguntaIndex}][respuesta_correcta]" value="${i}" class="pregunta-opcion">
                    </div>
                    <input type="text" name="preguntas[${preguntaIndex}][opciones][]" class="form-control pregunta-opcion" required placeholder="Opción ${i + 1}">
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
