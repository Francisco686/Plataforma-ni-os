<div id="verdadero_falso-template" class="card mb-3 d-none">
    <div class="card-header bg-info text-white">
        <i class="fas fa-check-circle me-1"></i> Actividad Verdadero/Falso
    </div>
    <div class="card-body">
        <input type="hidden" name="actividades[0][tipo]" value="verdadero_falso">

        <div class="mb-3">
            <label class="form-label">Pregunta *</label>
            <input type="text" class="form-control" name="actividades[0][pregunta]" required>
            <div class="invalid-feedback">La pregunta es requerida</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Respuesta Correcta *</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="actividades[0][respuesta_correcta]"
                       id="vf_verdadero_0" value="Verdadero" required>
                <label class="form-check-label" for="vf_verdadero_0">Verdadero</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="actividades[0][respuesta_correcta]"
                       id="vf_falso_0" value="Falso" required>
                <label class="form-check-label" for="vf_falso_0">Falso</label>
            </div>
            <div class="invalid-feedback">Debes seleccionar una opción</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Puntos</label>
            <input type="number" class="form-control" name="actividades[0][puntos]" min="1" value="1">
        </div>
    </div>
</div>
