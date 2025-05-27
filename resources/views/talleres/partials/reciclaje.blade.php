@extends('layouts.app')

@section('content')
<div class="container-fluid py-5 px-4 animate__animated animate__fadeIn">

    <!-- Botón de regreso -->
    <div class="mb-4 text-start">
        <a href="{{ route('talleres.index') }}" class="btn btn-lg btn-success shadow rounded-pill px-4">
            ♻️ Volver a mis talleres
        </a>
    </div>

    <!-- Sección: Cuento -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-light">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-recycle fa-2x me-3 text-success"></i>
                <h2 class="fw-bold mb-0 text-success">📘 Cuento: El Viaje de una Botella</h2>
            </div>
            <div class="px-2">
                <p class="fs-5">Había una vez una botella de plástico que fue arrojada al suelo. Triste y sola, soñaba con ser útil otra vez...</p>
                <p>Un día, una niña la recogió y la llevó al contenedor de reciclaje. ¡Qué emoción! La botella fue transformada en una banca del parque donde muchos niños jugaban 🛝.</p>
                <p class="fw-bold text-success">💡 Moraleja: Cada objeto puede tener una nueva vida si lo reciclamos correctamente.</p>
                <div class="text-center mt-3 mb-4">
    <img src="{{ asset('img/reciclajefeliz.png') }}"
         alt="Reciclaje feliz" class="img-fluid rounded shadow" style="max-height: 250px;">
</div>

            </div>
        </div>
    </section>

    <!-- Sección: Datos Curiosos -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-white">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-lightbulb fa-2x me-3 text-warning"></i>
                <h2 class="fw-bold mb-0 text-warning">💡 Datos Curiosos del Reciclaje</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="p-3 mb-3 bg-light border-start border-4 border-primary rounded">
                        <h5 class="text-primary">🌎 ¡Reduce, Reutiliza, Recicla!</h5>
                        <p>Reciclar una lata ahorra energía suficiente para encender una tele por 3 horas.</p>
                    </div>
                    <div class="p-3 mb-3 bg-light border-start border-4 border-info rounded">
                        <h5 class="text-info">📦 Papel salvado</h5>
                        <p>Reciclar una tonelada de papel salva 17 árboles 🌳.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 mb-3 bg-light border-start border-4 border-success rounded">
                        <h5 class="text-success">👟 Nuevas formas</h5>
                        <p>Botellas de plástico recicladas pueden convertirse en ropa o mochilas 🎒.</p>
                    </div>
                    <div class="p-3 mb-3 bg-light border-start border-4 border-danger rounded">
                        <h5 class="text-danger">🗑️ Basura que contamina</h5>
                        <p>Un solo residuo plástico puede tardar más de 400 años en desaparecer 😱.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: ¿Cómo Reciclar? -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-light">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-hand-holding-usd fa-2x me-3 text-success"></i>
                <h2 class="fw-bold mb-0 text-success">♻️ ¿Cómo reciclar correctamente?</h2>
            </div>
            <ul class="fs-5">
                <li>🟡 Separa los residuos: papel, plástico, vidrio y orgánico.</li>
                <li>🧼 Lava los envases antes de reciclarlos.</li>
                <li>🗑️ Usa los botes con color correcto según el material.</li>
                <li>🏡 Haz reciclaje desde casa y comparte el hábito con tu familia.</li>
            </ul>
        </div>
    </section>

   <!-- Sección: Galería del Reciclaje -->
<!-- Sección: Galería del Reciclaje -->
<section class="mb-5 animate__animated animate__fadeInUp">
    <div class="card p-4 shadow bg-white">
        <div class="d-flex align-items-center mb-4">
            <i class="fas fa-images fa-2x me-3 text-info"></i>
            <h2 class="fw-bold mb-0 text-info">🖼️ Galería del Reciclaje</h2>
        </div>
        <div class="row g-3">
            <div class="col-6 col-md-3">
               <img src="{{ asset('img/reciclaje1.jpeg') }}" class="img-fluid rounded shadow" alt="Imagen 1">
            </div>
            <div class="col-6 col-md-3">
               <img src="{{ asset('img/reciclaje2.jpeg') }}" class="img-fluid rounded shadow" alt="Imagen 2">
            </div>
            <div class="col-6 col-md-3">
                <img src="{{ asset('img/reciclaje3.jpeg') }}" class="img-fluid rounded shadow" alt="Imagen 3">
            </div>
            <div class="col-6 col-md-3">
               <img src="{{ asset('img/reciclaje4.jpeg') }}" class="img-fluid rounded shadow" alt="Imagen 4">
            </div>
        </div>
    </div>
</section>



    <!-- Sección: Videos -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-light">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-film fa-2x me-3 text-danger"></i>
                <h2 class="fw-bold mb-0 text-danger">🎬 Videos sobre Reciclaje</h2>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/-UFFFUTMlCw" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="mt-2">
                        <h5 class="fw-bold">¿Qué es Reciclar?</h5>
                        <p>Un video para niños sobre el reciclaje y su importancia 🌱.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/uaI3PLmAJyM" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="mt-2">
                        <h5 class="fw-bold">Cómo Separar la Basura</h5>
                        <p>Aprende a usar los colores de los botes de basura 🟥🟩🟦.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<style>
    html, body {
        min-height: 100vh;
        overflow-x: hidden;
        overflow-y: auto !important;
        background-color: #eafdf0;
        scroll-behavior: smooth;
    }

    .container-fluid {
        padding-bottom: 6rem !important;
    }

    .card {
        overflow: visible !important;
        border-radius: 1rem;
    }

    iframe {
        border-radius: 0.5rem;
    }

    p, li {
        font-size: 1.2rem;
    }

    .btn-success {
        font-size: 1.2rem;
    }
</style>
@endsection
