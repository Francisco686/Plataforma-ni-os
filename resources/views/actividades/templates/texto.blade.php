<div id="texto-template" class="card mb-3 d-none">
    <div class="card-header">
        <input type="hidden" name="actividades[0][tipo]" value="texto">
        <h5 class="mb-0">Texto Informativo</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Contenido del Texto *</label>
            <textarea class="form-control" name="actividades[0][contenido]" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Puntos (opcional)</label>
            <input type="number" class="form-control" name="actividades[0][puntos]" min="0" value="1">
        </div>
    </div>
</div>
