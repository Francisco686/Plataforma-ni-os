@extends('layouts.app')

@section('content')
<div class="container-fluid py-5 px-4 animate__animated animate__fadeIn">

    <!-- Botón de regreso -->
    <div class="mb-4 text-start">
        <a href="{{ route('talleres.index') }}" class="btn btn-lg btn-info shadow rounded-pill px-4">
            🔁 Volver a mis talleres
        </a>
    </div>

    <!-- Sección: Cuento -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-light">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-box-open fa-2x me-3 text-info"></i>
                <h2 class="fw-bold mb-0 text-info">📘 Cuento: El Viaje del Frasco Mágico</h2>
            </div>
            <div class="px-2">
                <p class="fs-5">Un frasco de vidrio pensaba que su historia había terminado cuando se vació. Pero una niña lo convirtió en un florero hermoso 🌼.</p>
                <p>Luego, fue una lámpara, un portalápices y hasta una maceta. El frasco se sintió feliz de tener muchos usos en vez de acabar en la basura 💡.</p>
                <p class="fw-bold text-info">💡 Moraleja: Reutilizar da nuevas oportunidades a los objetos y al planeta.</p>
                <div class="text-center mt-3 mb-4">
                    <img src="{{ asset('img/reutilizarfeliz.jpg') }}"
                         alt="Reutilizar feliz" class="img-fluid rounded shadow" style="max-height: 250px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Datos Curiosos -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-white">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-lightbulb fa-2x me-3 text-warning"></i>
                <h2 class="fw-bold mb-0 text-warning">💡 Datos Curiosos de Reutilizar</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="p-3 mb-3 bg-light border-start border-4 border-warning rounded">
                        <h5 class="text-warning">♻️ Reutilizar es ahorrar</h5>
                        <p>Reutilizar una bolsa 5 veces reduce su impacto ambiental en un 60%.</p>
                    </div>
                    <div class="p-3 mb-3 bg-light border-start border-4 border-success rounded">
                        <h5 class="text-success">🧃 De botellas a macetas</h5>
                        <p>Muchas personas hacen jardines usando botellas y latas viejas 🌿.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 mb-3 bg-light border-start border-4 border-info rounded">
                        <h5 class="text-info">🧠 Creatividad ecológica</h5>
                        <p>Reutilizar estimula la imaginación para crear cosas nuevas ✂️.</p>
                    </div>
                    <div class="p-3 mb-3 bg-light border-start border-4 border-danger rounded">
                        <h5 class="text-danger">🚫 Menos basura</h5>
                        <p>Entre más reutilizamos, menos basura llega a los ríos y al mar 🌊.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Cómo Reutilizar -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-light">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-sync-alt fa-2x me-3 text-info"></i>
                <h2 class="fw-bold mb-0 text-info">🔁 ¿Cómo reutilizar en casa?</h2>
            </div>
            <ul class="fs-5">
                <li>🧺 Usa frascos vacíos como organizadores.</li>
                <li>📦 Convierte cajas en juguetes o estanterías.</li>
                <li>🧦 Crea marionetas con calcetines viejos.</li>
                <li>🛍️ Lleva bolsas reutilizables al mercado.</li>
            </ul>
        </div>
    </section>

    <!-- Sección: Galería -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-white">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-images fa-2x me-3 text-success"></i>
                <h2 class="fw-bold mb-0 text-success">🖼️ Galería de Reutilización</h2>
            </div>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <img src="{{ asset('img/reutil1.jpeg') }}" class="img-fluid rounded shadow" alt="Reutil 1">
                </div>
                <div class="col-6 col-md-3">
                    <img src="{{ asset('img/reutil2.jpeg') }}" class="img-fluid rounded shadow" alt="Reutil 2">
                </div>
                <div class="col-6 col-md-3">
                    <img src="{{ asset('img/reutil3.jpeg') }}" class="img-fluid rounded shadow" alt="Reutil 3">
                </div>
                <div class="col-6 col-md-3">
                    <img src="{{ asset('img/reutil4.jpeg') }}" class="img-fluid rounded shadow" alt="Reutil 4">
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Videos -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-light">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-film fa-2x me-3 text-danger"></i>
                <h2 class="fw-bold mb-0 text-danger">🎬 Videos para aprender</h2>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/cvakvfXj0KE" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="mt-2">
                        <h5 class="fw-bold">Ideas para reutilizar</h5>
                        <p>Un video con manualidades útiles y divertidas.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/0cEv6-lv3lU" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="mt-2">
                        <h5 class="fw-bold">Reutiliza desde casa</h5>
                        <p>Descubre cómo puedes ayudar al planeta sin salir de tu hogar.</p>
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
        background-color: #eaf9ff;
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

    .btn-info {
        font-size: 1.2rem;
    }
</style>
@endsection
