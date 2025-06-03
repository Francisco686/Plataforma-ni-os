<div id="opcion_multiple-template" class="card mb-3 d-none">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-list-ol me-1"></i> Actividad de Opción Múltiple
    </div>
    <div class="card-body">
        <input type="hidden" name="actividades[0][tipo]" value="opcion_multiple">

        <div class="mb-3">
            <label class="form-label">Pregunta *</label>
            <input type="text" class="form-control" name="actividades[0][pregunta]" required>
            <div class="invalid-feedback">La pregunta es requerida</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Opciones * (Mínimo 2)</label>
            <div class="options-container">
                <!-- Las opciones se agregarán dinámicamente aquí -->
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary mt-2 add-option">
                <i class="fas fa-plus me-1"></i> Agregar Opción
            </button>
            <div class="invalid-feedback">Debes agregar al menos 2 opciones y seleccionar una correcta</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Puntos</label>
            <input type="number" class="form-control" name="actividades[0][puntos]" min="1" value="1">
        </div>
    </div>
</div>
