@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Agregar Sección al Taller: <span class="text-primary">{{ $taller->titulo }}</span></h2>

    <form action="{{ route('secciones.store', $taller) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Tipo de Sección</label>
            <select name="tipo" class="form-select" id="tipo" required>
                <option value="">Seleccione una opción</option>
                <option value="lectura">Lectura</option>
                <option value="actividad">Actividad</option>
                <option value="test">Test</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Título de la Sección</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contenido o Instrucciones</label>
            <textarea name="descripcion" class="form-control" rows="3" required></textarea>
        </div>

        {{-- Opciones solo para tipo test --}}
        <div class="mb-3 d-none" id="test-opciones">
            <label class="form-label">Opciones del Test</label>
            <div id="opciones-lista">
                <div class="input-group mb-2">
                    <input type="text" name="opciones[]" class="form-control" placeholder="Opción 1">
                    <div class="input-group-text">
                        <input type="radio" name="respuesta_correcta" value="0" class="respuesta-radio">
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary" id="agregar-opcion">
                + Añadir otra opción
            </button>
            <small class="form-text text-muted d-block mt-1">Marca cuál es la respuesta correcta</small>
        </div>

        <div class="mt-4 text-center">
            <button type="submit" class="btn btn-success px-4 rounded-pill">
                <i class="fas fa-plus-circle me-2"></i> Guardar Sección
            </button>
        </div>
    </form>
</div>

{{-- Script para mostrar/ocultar dinámicamente --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoSelect = document.getElementById('tipo');
        const testOpciones = document.getElementById('test-opciones');
        const opcionesLista = document.getElementById('opciones-lista');
        const agregarBtn = document.getElementById('agregar-opcion');

        tipoSelect.addEventListener('change', function () {
            const esTest = tipoSelect.value === 'test';
            testOpciones.classList.toggle('d-none', !esTest);

            // Si es test, los radios deben ser required; si no, no
            document.querySelectorAll('.respuesta-radio').forEach(radio => {
                if (esTest) {
                    radio.setAttribute('required', 'required');
                } else {
                    radio.removeAttribute('required');
                }
            });
        });

        agregarBtn.addEventListener('click', function () {
            const index = opcionesLista.querySelectorAll('.input-group').length;
            const html = `
                <div class="input-group mb-2">
                    <input type="text" name="opciones[]" class="form-control" placeholder="Opción ${index + 1}">
                    <div class="input-group-text">
                        <input type="radio" name="respuesta_correcta" value="${index}" class="respuesta-radio">
                    </div>
                </div>
            `;
            opcionesLista.insertAdjacentHTML('beforeend', html);
        });
    });
</script>
@endsection
