<div id="video-template" class="card mb-3 d-none">
    <div class="card-header bg-primary text-white">
        <i class="fas fa-video me-1"></i> Actividad con Video
    </div>
    <div class="card-body">
        <input type="hidden" name="actividades[0][tipo]" value="video">

        <div class="mb-3">
            <label class="form-label">URL del Video (YouTube/Vimeo) *</label>
            <input type="text" class="form-control" name="actividades[0][video_url]" required>
            <small class="text-muted">Ej: https://www.youtube.com/watch?v=ABCD1234</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Pregunta sobre el video *</label>
            <input type="text" class="form-control" name="actividades[0][contenido]" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Respuesta Correcta *</label>
            <input type="text" class="form-control" name="actividades[0][respuesta_correcta]" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Puntos</label>
            <input type="number" class="form-control" name="actividades[0][puntos]" min="1" value="1">
        </div>
    </div>
</div>
