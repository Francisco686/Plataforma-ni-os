@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Agregar Sección al Taller: <span class="text-primary">{{ $taller->titulo }}</span></h2>

    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-9">
            <div class="card shadow rounded-4">
                <div class="card-body">
                    <form action="{{ route('secciones.store', $taller) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tipo" class="form-label fw-semibold">Tipo de Sección</label>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="lectura">Lectura</option>
                                <option value="actividad">Actividad</option>
                                <option value="test">Test (cuestionario)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label fw-semibold">Título de la Sección</label>
                            <input type="text" name="nombre" class="form-control" required placeholder="Ej. Cuestionario Ambiental">
                        </div>

                        <div class="mb-3" id="instrucciones-box">
                            <label for="descripcion" class="form-label">Contenido / Instrucciones</label>
                            <textarea name="descripcion" class="form-control" rows="3" placeholder="Contenido o instrucciones para los alumnos"></textarea>
                        </div>

                        {{-- Contenedor de preguntas (solo visible para tipo test) --}}
                        <div id="preguntas-container" style="display: none;">
                            <label class="form-label fw-bold">Preguntas del Test</label>

                            <div class="card mb-3 p-3 shadow-sm rounded border pregunta-item">
                                <div class="mb-2">
                                    <label class="form-label">Pregunta 1</label>
                                    <input type="text" name="preguntas[0][pregunta]" class="form-control" required>
                                </div>

                                <div class="mb-2 opciones-box">
                                    @for($i = 0; $i < 2; $i++)
                                        <div class="input-group mb-2">
                                            <div class="input-group-text">
                                                <input type="radio" name="preguntas[0][correcta]" value="{{ $i }}" required>
                                            </div>
                                            <input type="text" name="preguntas[0][opciones][]" class="form-control" required placeholder="Opción {{ $i + 1 }}">
                                        </div>
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
                <input type="text" name="preguntas[${preguntaIndex}][pregunta]" class="form-control" required>
            </div>

            <div class="mb-2 opciones-box">
        `;

        for (let i = 0; i < 2; i++) {
            contenido += `
                <div class="input-group mb-2">
                    <div class="input-group-text">
                        <input type="radio" name="preguntas[${preguntaIndex}][correcta]" value="${i}" required>
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
