@extends('layouts.app')

@section('content')
<div class="container-fluid py-5 px-4 animate__animated animate__fadeIn">

    <!-- Botón de regreso -->
    <div class="mb-4 text-start">
        <a href="{{ route('talleres.index') }}" class="btn btn-lg btn-warning shadow rounded-pill px-4">
            ⬅️ Volver a mis talleres
        </a>
    </div>

    <!-- Sección: Cuento -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-light">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-book-open fa-2x me-3 text-primary"></i>
                <h2 class="fw-bold mb-0 text-primary">📖 Cuento: La Aventura de una Gotita</h2>
            </div>
            <div class="px-2">
                <p class="fs-5">Había una vez una pequeña gota de agua llamada <strong>Gota</strong> que vivía en el océano…</p>
                <p>Un día, el sol la calentó tanto que comenzó a evaporarse y subió al cielo. Allí se unió a otras gotitas para formar una nube blanca y esponjosa ☁️.</p>
                <p>Cuando la nube se enfrió, Gota cayó como lluvia sobre una montaña, corrió por un río, fue bebida por un animalito 🐿️, y finalmente regresó al mar 🌊 para comenzar su viaje otra vez.</p>
                <p class="fw-bold text-success">🌟 Moraleja: El agua nunca desaparece, solo cambia de lugar en su ciclo interminable.</p>
                <div class="text-center mt-3 mb-4">
                    <img src="https://cdn.pixabay.com/photo/2020/06/07/05/48/drop-5269146_1280.jpg"
                         alt="Gota de agua" class="img-fluid rounded shadow" style="max-height: 250px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Datos Curiosos -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-white">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-lightbulb fa-2x me-3 text-warning"></i>
                <h2 class="fw-bold mb-0 text-warning">💡 Datos Curiosos del Agua</h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="p-3 mb-3 bg-light border-start border-4 border-warning rounded">
                        <h5 class="text-warning">💧 ¿Sabías que...?</h5>
                        <p>El 70% de la Tierra es agua, pero solo el 3% es dulce.</p>
                    </div>
                    <div class="p-3 mb-3 bg-light border-start border-4 border-info rounded">
                        <h5 class="text-info">⏳ Una gota viajera</h5>
                        <p>Una molécula de agua puede estar 3,000 años en el océano antes de evaporarse.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 mb-3 bg-light border-start border-4 border-success rounded">
                        <h5 class="text-success">👶 Agua en tu cuerpo</h5>
                        <p>Los bebés tienen un 78% de agua en su cuerpo.</p>
                    </div>
                    <div class="p-3 mb-3 bg-light border-start border-4 border-danger rounded">
                        <h5 class="text-danger">🌍 Agua escondida</h5>
                        <p>Producir una hamburguesa usa hasta 2,400 litros de agua 💧🍔.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Cómo cuidar el agua -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-light">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-hand-holding-water fa-2x me-3 text-success"></i>
                <h2 class="fw-bold mb-0 text-success">💚 ¿Cómo cuidar el agua?</h2>
            </div>
            <ul class="fs-5">
                <li>🚿 Toma duchas cortas.</li>
                <li>🪥 Cierra el grifo mientras te cepillas los dientes.</li>
                <li>🌿 Usa agua reciclada para regar plantas.</li>
                <li>🧴 No tires aceite ni basura por el drenaje.</li>
            </ul>
        </div>
    </section>

    <!-- Sección: Galería -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-white">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-images fa-2x me-3 text-info"></i>
                <h2 class="fw-bold mb-0 text-info">🖼️ Galería del Agua</h2>
            </div>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <img src="https://media.istockphoto.com/id/1340716614/photo/abstract-icon-representing-the-ecological-call-to-recycle-and-reuse-in-the-form-of-a-pond.jpg?s=2048x2048"
                         class="img-fluid rounded shadow" alt="Reciclaje de agua">
                </div>
                <div class="col-6 col-md-3">
                    <img src="https://images.unsplash.com/photo-1531533748270-34089046fb49?q=80"
                         class="img-fluid rounded shadow" alt="Gotas de agua">
                </div>
                <div class="col-6 col-md-3">
                    <img src="https://images.unsplash.com/photo-1495727034151-8fdc73e332a8"
                         class="img-fluid rounded shadow" alt="Niño tomando agua">
                </div>
            </div>
        </div>
    </section>

    <!-- Sección: Videos -->
    <section class="mb-5 animate__animated animate__fadeInUp">
        <div class="card p-4 shadow bg-light">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-film fa-2x me-3 text-danger"></i>
                <h2 class="fw-bold mb-0 text-danger">🎬 Videos Educativos</h2>
            </div>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/WGe8WbOKXJg" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="mt-2">
                        <h5 class="fw-bold">El Ciclo del Agua</h5>
                        <p>Aprende cómo el agua viaja por nuestro planeta.</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/TOD_9kWu3bA" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div class="mt-2">
                        <h5 class="fw-bold">Cómo Cuidar el Agua</h5>
                        <p>Pequeñas acciones que hacen una gran diferencia.</p>
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

    .btn-warning {
        font-size: 1.2rem;
    }
</style>
@endsection
