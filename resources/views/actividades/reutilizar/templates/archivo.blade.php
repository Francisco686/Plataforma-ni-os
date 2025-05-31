<div id="archivo-template" class="card mb-3 d-none">
    <div class="card-header">
        <input type="hidden" name="actividades[0][tipo]" value="archivo">
        <h5 class="mb-0">Subir Archivo</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Instrucciones (opcional)</label>
            <input type="text" class="form-control" name="actividades[0][pregunta]">
        </div>
        <div class="mb-3">
            <label class="form-label">Archivo de Referencia *</label>
            <input type="file" class="form-control" name="actividades[0][archivo_referencia]" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Puntos (opcional)</label>
            <input type="number" class="form-control" name="actividades[0][puntos]" min="0" value="1">
        </div>
    </div>
</div>
