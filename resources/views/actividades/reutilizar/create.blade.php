@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-tasks me-2"></i>Crear Nueva Sesión de Actividades</h4>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ route('actividades.reutilizar.index') }}"
                           class="btn mt-1"
                           style="
                        background: linear-gradient(90deg, #a8edea, #43cea2);
                        color: #000 !important;
                        border: none;
                        padding: 10px 40px;
                        font-weight: 400;
                        letter-spacing: 1px;
                        border-radius: 8px;
                        min-width: 250px;
                        text-align: center;
                        display: inline-block;
                        transition: background 0.3s ease;">
                            <i class="fas fa-arrow-left me-2"></i> Volver
                        </a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('actividades.reutilizar.store') }}" method="POST" enctype="multipart/form-data" id="activity-form">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="titulo" class="form-label">Título de la Sesión *</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                                    <div class="invalid-feedback">Por favor ingresa un título para la sesión</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="fecha_limite" class="form-label">Fecha Límite</label>
                                    <input type="datetime-local" class="form-control" id="fecha_limite" name="fecha_limite">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="descripcion" class="form-label">Instrucciones Generales</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
                            </div>

                            <div class="mb-4 p-3 border rounded bg-light">
                                <h5 class="mb-3">Agregar Nueva Actividad:</h5>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-primary btn-add-activity" data-type="texto">
                                        <i class="fas fa-align-left me-1"></i> Texto Informativo
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-add-activity" data-type="pregunta">
                                        <i class="fas fa-question-circle me-1"></i> Pregunta Simple
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-add-activity" data-type="opcion_multiple">
                                        <i class="fas fa-list-ol me-1"></i> Opción Múltiple
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-add-activity" data-type="verdadero_falso">
                                        <i class="fas fa-check-circle me-1"></i> Verdadero/Falso
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-add-activity" data-type="video">
                                        <i class="fas fa-video me-1"></i> Video + Pregunta
                                    </button>
                                    <button type="button" class="btn btn-outline-primary btn-add-activity" data-type="archivo">
                                        <i class="fas fa-file-upload me-1"></i> Subir Archivo
                                    </button>
                                </div>
                            </div>

                            <div id="actividades-container" class="mb-4">
                                @if(old('actividades'))
                                    <!-- Si hay datos antiguos (por ejemplo, después de un error de validación) -->
                                    @foreach(old('actividades') as $index => $actividad)
                                        @include('actividades.reutilizar.templates.'.$actividad['tipo'], [
                                            'activityId' => $index,
                                            'oldData' => $actividad
                                        ])
                                    @endforeach
                                @endif
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="button" id="btn-preview" class="btn btn-outline-secondary">
                                    <i class="fas fa-eye me-1"></i> Vista Previa
                                </button>
                                <div>
                                    <button type="reset" class="btn btn-outline-danger me-2">
                                        <i class="fas fa-trash-alt me-1"></i> Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i> Guardar Sesión
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para vista previa -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Vista Previa de la Sesión</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="preview-content"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir templates -->
    @include('actividades.reutilizar.templates.texto')
    @include('actividades.reutilizar.templates.pregunta')
    @include('actividades.reutilizar.templates.opcion_multiple')
    @include('actividades.reutilizar.templates.verdadero_falso')
    @include('actividades.reutilizar.templates.video')
    @include('actividades.reutilizar.templates.archivo')
@endsection

@section('styles')
    <style>
        .activity-card {
            transition: all 0.3s ease;
            border-left: 4px solid #0d6efd;
            margin-bottom: 1rem;
        }
        .texto-activity {
            border-left-color: #6c757d;
        }
        .activity-card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .btn-add-option {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
        .sortable-ghost {
            opacity: 0.6;
            background: #cce5ff;
        }
        .drag-handle {
            cursor: move;
            margin-right: 0.5rem;
        }
        .remove-activity {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
        }
        .card-header {
            position: relative;
        }
        .is-invalid {
            border-color: #dc3545;
        }
        .invalid-feedback {
            display: none;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        .was-validated .form-control:invalid ~ .invalid-feedback,
        .form-control.is-invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>

    <script>
        $(document).ready(function() {
            // Variables globales
            let activityCounter = {{ old('actividades') ? count(old('actividades')) : 0 }};
            const $container = $('#actividades-container');
            const $form = $('#activity-form');

            // 1. Inicializar SortableJS para arrastrar actividades
            if ($container.length) {
                new Sortable($container[0], {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    onEnd: function() {
                        console.log('Orden de actividades actualizado');
                    }
                });
            }

            // 2. Manejador para agregar actividades
            $(document).on('click', '.btn-add-activity', function() {
                const type = $(this).data('type');
                addActivity(type);
            });

            // 3. Función para agregar una nueva actividad
            function addActivity(type) {
                const $template = $(`#${type}-template`);

                if (!$template.length) {
                    console.error(`Template no encontrado para tipo: ${type}`);
                    alert(`Error: No se encontró la plantilla para ${type}`);
                    return;
                }

                const activityId = activityCounter++;
                const $clone = $template.clone()
                    .removeClass('d-none')
                    .removeAttr('id')
                    .addClass('activity-card')
                    .addClass(`${type}-activity`);

                // Actualizar todos los índices en los names
                $clone.html($clone.html().replace(/\[0\]/g, `[${activityId}]`));

                // Agregar controles (eliminar y arrastrar)
                $clone.find('.card-header').prepend(`
                    <span class="drag-handle btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-arrows-alt"></i>
                    </span>
                `).append(`
                    <button type="button" class="btn btn-sm btn-danger remove-activity">
                        <i class="fas fa-times"></i>
                    </button>
                `);

                // Configuración especial para opción múltiple
                if (type === 'opcion_multiple') {
                    // Asegurar al menos una opción
                    addOption($clone, activityId);
                }
                console.log('Actividad agregada:', {
                    id: activityId,
                    type: type,
                    html: $clone.html()
                });

                $container.append($clone);
            }

            // 4. Función para agregar opciones en actividades de opción múltiple
            function addOption($activity, activityId, optionValue = '') {
                const $optionsContainer = $activity.find('.options-container');
                const optionIndex = $optionsContainer.children().length;

                // Solo permitir agregar si hay menos de 10 opciones
                if (optionIndex >= 10) {
                    alert('Máximo 10 opciones permitidas');
                    return;
                }

                const $option = $(`
                    <div class="option-item mb-2 d-flex align-items-center">
                        <div class="flex-grow-1 d-flex align-items-center">
                            <input type="radio" name="actividades[${activityId}][respuesta_correcta]"
                                   value="${optionIndex}" class="me-2 correct-option-radio" required>
                            <input type="text" class="form-control form-control-sm option-input"
                                   name="actividades[${activityId}][opciones][${optionIndex}]"
                                   value="${optionValue}" required>
                            <div class="invalid-feedback">La opción no puede estar vacía</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger ms-2 remove-option">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);

                $optionsContainer.append($option);
            }

            // 5. Manejadores de eventos delegados
            $(document)
                // Eliminar actividad
                .on('click', '.remove-activity', function() {
                    $(this).closest('.activity-card').remove();
                })
                // Agregar opción (para opción múltiple)
                .on('click', '.add-option', function() {
                    const $activity = $(this).closest('.activity-card');
                    const activityId = $activity.find('input[name^="actividades["]').attr('name').match(/\[(\d+)\]/)[1];
                    addOption($activity, activityId);
                })
                // Eliminar opción
                .on('click', '.remove-option', function() {
                    const $optionItem = $(this).closest('.option-item');
                    const $container = $optionItem.closest('.options-container');

                    if ($container.children().length <= 1) {
                        alert('Debe haber al menos una opción');
                        return;
                    }

                    $optionItem.remove();
                    reindexOptions($container);
                })
                // Vista previa
                .on('click', '#btn-preview', function() {
                    generatePreview();
                });

            // 6. Función para reindexar opciones después de eliminar
            function reindexOptions($container) {
                $container.find('.option-item').each(function(newIndex) {
                    const $radio = $(this).find('.correct-option-radio');
                    const $input = $(this).find('.option-input');

                    // Actualizar valor del radio
                    $radio.val(newIndex);

                    // Actualizar nombre del input de opción
                    const currentName = $input.attr('name');
                    $input.attr('name', currentName.replace(/\[\d+\]/, `[${newIndex}]`));
                });
            }

            // 7. Función para generar vista previa
            function generatePreview() {
                const $previewContent = $('#preview-content');
                const modal = new bootstrap.Modal(document.getElementById('previewModal'));

                // Limpiar contenido previo
                $previewContent.empty();

                // Agregar información básica
                $previewContent.append(`
                    <h3>${$('#titulo').val() || 'Sin título'}</h3>
                    ${$('#descripcion').val() ? `<div class="alert alert-light">${$('#descripcion').val()}</div>` : ''}
                    <hr>
                    <h4>Actividades:</h4>
                    <div class="preview-activities-container"></div>
                `);

                const $previewActivities = $previewContent.find('.preview-activities-container');
                const $activities = $container.children('.activity-card').clone();

                if ($activities.length === 0) {
                    $previewActivities.html('<div class="alert alert-warning">No hay actividades agregadas</div>');
                } else {
                    $activities.each(function() {
                        const $activity = $(this);
                        const type = $activity.find('input[name*="[tipo]"]').val() || 'desconocido';

                        // Limpiar elementos interactivos
                        $activity.find('.remove-activity, .drag-handle, .add-option, .remove-option').remove();

                        // Estilo especial para vista previa
                        $activity.css({
                            'pointer-events': 'none',
                            'opacity': '1'
                        });

                        // Identificar tipo de actividad
                        $activity.find('.card-header').prepend(`<span class="badge bg-info me-2">${type}</span>`);

                        $previewActivities.append($activity);
                    });
                }

                // Mostrar modal
                modal.show();
            }
            $form.on('submit', function(e) {
                let isValid = true;
                const $firstInvalid = $('.is-invalid').first();

                // Resetear validación
                $('.is-invalid').removeClass('is-invalid');
                $('.invalid-feedback').hide();

                // Validar título
                if (!$('#titulo').val().trim()) {
                    $('#titulo').addClass('is-invalid');
                    isValid = false;
                    if (!$firstInvalid.length) $firstInvalid = $('#titulo');
                }

                // Validar cada actividad
                $('.activity-card').each(function() {
                    const $activity = $(this);
                    const tipo = $activity.find('input[name$="[tipo]"]').val();
                    const $cardBody = $activity.find('.card-body');

                    // Validar que el tipo está presente
                    if (!tipo) {
                        $activity.addClass('is-invalid');
                        isValid = false;
                        if (!$firstInvalid.length) $firstInvalid = $activity;
                        return;
                    }

                    // Validar pregunta (requerida para todos excepto texto)
                    if (tipo !== 'texto') {
                        const $pregunta = $activity.find('input[name$="[pregunta]"], textarea[name$="[pregunta]"]');
                        if (!$pregunta.val() || !$pregunta.val().trim()) {
                            $pregunta.addClass('is-invalid');
                            isValid = false;
                            if (!$firstInvalid.length) $firstInvalid = $pregunta;
                        }
                    }

                    // Validación específica por tipo
                    switch(tipo) {
                        case 'opcion_multiple':
                            // Validar que hay al menos 2 opciones
                            const $opciones = $cardBody.find('.option-input');
                            let opcionesValidas = 0;

                            $opciones.each(function() {
                                if ($(this).val().trim() === '') {
                                    $(this).addClass('is-invalid');
                                    isValid = false;
                                } else {
                                    opcionesValidas++;
                                }
                            });

                            if (opcionesValidas < 2) {
                                $cardBody.find('.options-container').addClass('is-invalid');
                                isValid = false;
                                if (!$firstInvalid.length) $firstInvalid = $cardBody.find('.options-container');
                            }

                            // Validar que se ha seleccionado una respuesta correcta
                            if ($cardBody.find('.correct-option-radio:checked').length === 0) {
                                $cardBody.find('.options-container').addClass('is-invalid');
                                isValid = false;
                                if (!$firstInvalid.length) $firstInvalid = $cardBody.find('.options-container');
                            }
                            break;

                        case 'verdadero_falso':
                            if ($cardBody.find('input[name$="[respuesta_correcta]"]:checked').length === 0) {
                                $cardBody.find('.form-check-input').addClass('is-invalid');
                                isValid = false;
                                if (!$firstInvalid.length) $firstInvalid = $cardBody.find('.form-check-input');
                            }
                            break;
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    // Desplazarse al primer error
                    $('html, body').animate({
                        scrollTop: $firstInvalid.offset().top - 100
                    }, 500);

                    return false;
                }

                return true;
            });
        });
    </script>
@endsection
