<div id="pregunta-template" class="d-none">
    <div class="card mb-3 activity-card">
        <div class="card-header d-flex justify-content-between align-items-center bg-light position-relative">
            <h5 class="mb-0">Pregunta Simple</h5>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Pregunta *</label>
                <textarea class="form-control" name="actividades[0][pregunta]" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Respuesta Correcta (Opcional)</label>
                <textarea class="form-control" name="actividades[0][respuesta_correcta]" rows="2"></textarea>
            </div>
            <input type="hidden" name="actividades[0][tipo]" value="pregunta">
        </div>
    </div>
</div>
