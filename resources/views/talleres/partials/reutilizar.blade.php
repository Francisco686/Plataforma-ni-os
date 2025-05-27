@extends('layouts.customHome')

@section('content')
    <div class="container-fluid p-0 home-background" style="background-size: cover; background-position: center; min-height: 100vh; margin: 0; padding: 0;">
        <div class="row no-gutters" style="min-height: 100vh; margin: 0;">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="w-100 px-3 px-md-5 contenido-principal" style="margin-top: 2380px;">
                    <div class="text-center welcome-message" style="margin-top: 60px;">
                        <div class="animate__animated animate__fadeInDown">
                            <h1 class="text-white font-weight-bold mb-3"><strong>¡Bienvenid@, {{ Auth::user()->name }}!</strong></h1>

                            @if(Auth::user()->role === 'alumno' && Auth::user()->grupo)
                                <div class="alert alert-info text-center mb-4">
                                    Tu grupo es: <strong>{{ Auth::user()->grupo->grado }}°{{ strtoupper(Auth::user()->grupo->grupo) }}</strong>
                                </div>
                            @endif
                        </div>


                        @if(Auth::user()->role === 'alumno')

                            <div class="tab-content " id="tab-reutilizar">
                                <!-- Pestaña Inicio -->
                                <section id="seccion-bienvenida-reutilizar" class="mb-5 scroll-margin-top" style="scroll-margin-top: 100px;">
                                    <div class="card bg-white text-dark p-4 shadow">
                                        <h4 class="fw-bold">Bienvenido a la sección de Reutilizar</h4>
                                        <p>Conoce cómo darle nueva vida a objetos que ya no usas.</p>
                                    </div>
                                </section>

                                <div class="animate__animated animate__fadeIn">
                                    <!-- Historia -->
                                    <section id="seccion-cuento-reutilizar" class="row mb-4 scroll-margin-top" style="scroll-margin-top: 100px;">
                                        <div class="col-12">
                                            <div class="card bg-white text-dark p-4 shadow">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-recycle fa-2x me-3 text-success"></i>
                                                    <h4 class="mb-0 fw-bold">Historia: “Tomás y el Tesoro del Reciclaje”</h4>
                                                </div>
                                                <div class="px-4">
                                                    <p class="lead">Tomás era un niño curioso que un día encontró un mapa en su jardín con un mensaje que decía:
                                                        "Sigue las pistas y encuentra el tesoro que salva al planeta". Al llegar al parque, encontró un bote de
                                                        reciclaje donde una botella le habló y le explicó que si la reciclaban, podría tener una nueva vida y no
                                                        contaminar el planeta. Desde entonces, Tomás entendió que el verdadero tesoro era el reciclaje, porque
                                                        ayudaba a cuidar la Tierra, y enseñó a sus amigos a separar la basura y a reutilizar los materiales.</p>
                                                    <p> Con unas botellas vacías, un cartón viejo y mucha imaginación, Tomás y sus amigos construyeron un divertido
                                                        juego de bolos en lugar de tirarlos a la basura. Aprendieron que reciclar no solo ayuda al planeta,
                                                        ¡también puede ser muy divertido!.</p>
                                                    <p class="fw-bold text-success">Moraleja: Antes de tirar algo, piensa cómo podrías reutilizarlo.</p>
                                                    <div class="text-center mt-3">
                                                        <img src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=1350&q=80" alt="Juguetes reutilizados" class="img-fluid rounded" style="max-height: 200px;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <!-- Datos Curiosos -->
                                    <section id="seccion-datos-reutilizar" class="row mb-5 scroll-margin-top" style="scroll-margin-top: 100px;">
                                        <div class="col-12">
                                            <div class="card bg-white text-dark p-4 shadow">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-lightbulb fa-2x me-3 text-warning"></i>
                                                    <h4 class="mb-0 fw-bold">Datos Curiosos sobre Reutilización</h4>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded mb-3 border-start border-4 border-warning">
                                                            <h5 class="fw-bold text-warning">♻️ ¿Sabías que?</h5>
                                                            <p>Reutilizar 1 kg de plástico ahorra la energía equivalente a 3 horas de televisión.</p>
                                                        </div>
                                                        <div class="p-3 bg-light rounded mb-3 border-start border-4 border-info">
                                                            <h5 class="fw-bold text-info">💰 Ahorro increíble</h5>
                                                            <p>Una familia promedio puede ahorrar $1,000 al año reutilizando objetos en lugar de comprar nuevos.</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="p-3 bg-light rounded mb-3 border-start border-4 border-success">
                                                            <h5 class="fw-bold text-success">🌳 Beneficio ambiental</h5>
                                                            <p>Reutilizar una camiseta vieja como trapo evita la emisión de 4 kg de CO₂.</p>
                                                        </div>
                                                        <div class="p-3 bg-light rounded mb-3 border-start border-4 border-danger">
                                                            <h5 class="fw-bold text-danger">🧠 Creatividad</h5>
                                                            <p>Los niños que aprenden a reutilizar desarrollan un 30% más su creatividad según estudios.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>

                                    <section id="seccion-multimedia" class="row scroll-margin-top mb-5" style="scroll-margin-top: 100px;">
                                        <div class="col-12">
                                            <div class="card bg-white p-4 shadow">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-photo-video fa-2x me-3 text-primary"></i>
                                                    <h4 class="mb-0 fw-bold">Galería y Videos Educativos</h4>
                                                </div>
                                                <div class="row g-4">
                                                    <!-- Mitad imágenes -->
                                                    <div class="col-md-6">
                                                        <!-- HTML -->
                                                        <div class="row g-2">
                                                            <div class="col-6">
                                                                <img src="{{ asset('assets/images/reutilizar2.png') }}"
                                                                     alt="Reutilizar 2"
                                                                     class="rounded hover-zoom"
                                                                     data-bs-toggle="tooltip"
                                                                     title="Reutiliza materiales en casa">
                                                            </div>
                                                            <div class="col-6">
                                                                <img src="{{ asset('assets/images/reutilizar3.jpg') }}"
                                                                     alt="Reutilizar 3"
                                                                     class="rounded hover-zoom"
                                                                     data-bs-toggle="tooltip"
                                                                     title="Haz manualidades con botellas">
                                                            </div>
                                                            <div class="col-6">
                                                                <img src="{{ asset('assets/images/reutilizar4.jpg') }}"
                                                                     alt="Niño tomando agua"
                                                                     class="rounded hover-zoom"
                                                                     data-bs-toggle="tooltip"
                                                                     title="El agua nos da vida">
                                                            </div>
                                                            <div class="col-6">
                                                                <img src="{{ asset('assets/images/reutilizar5.jpg') }}"
                                                                     alt="Ahorrando agua"
                                                                     class="rounded hover-zoom"
                                                                     data-bs-toggle="tooltip"
                                                                     title="Todos podemos ayudar">
                                                            </div>
                                                            <div class="col-6">
                                                                <img src="{{ asset('assets/images/reutilizar6.jpg') }}"
                                                                     alt="Niño tomando agua"
                                                                     class="rounded hover-zoom"
                                                                     data-bs-toggle="tooltip"
                                                                     title="El agua nos da vida">
                                                            </div>
                                                            <div class="col-6">
                                                                <img src="{{ asset('assets/images/reutilizar7.jpg') }}"
                                                                     alt="Ahorrando agua"
                                                                     class="rounded hover-zoom"
                                                                     data-bs-toggle="tooltip"
                                                                     title="Todos podemos ayudar">
                                                            </div>
                                                        </div>

                                                        <!-- CSS -->
                                                        <style>
                                                            .row img {
                                                                width: 100%;
                                                                height: 200px;
                                                                object-fit: cover;
                                                            }
                                                        </style>

                                                    </div>
                                                    <!-- Mitad videos -->
                                                    <div class="col-md-6">
                                                        <div class="row g-3">
                                                            <div class="col-12">
                                                                <div class="card border-0">
                                                                    <div class="ratio ratio-16x9 rounded">
                                                                        <iframe src="https://www.youtube.com/embed/vBoKKzX4neU" frameborder="0" allowfullscreen></iframe>
                                                                    </div>
                                                                    <div class="card-body p-2">
                                                                        <h5 class="card-title fw-bold">Cosas que puedes reutilizar</h5>
                                                                        <p class="card-text small">Aprende cómo reutilizar.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="card border-0">
                                                                    <div class="ratio ratio-16x9 rounded">
                                                                        <iframe src="https://www.youtube.com/embed/cvakvfXj0KE" frameborder="0" allowfullscreen></iframe>
                                                                    </div>
                                                                    <div class="card-body p-2">
                                                                        <h5 class="card-title fw-bold">¿Qué es reutilizar?</h5>
                                                                        <p class="card-text small">Para mejorar el mundo.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> <!-- fin mitad videos -->
                                                </div> <!-- fin row g-4 -->
                                            </div> <!-- fin card -->
                                        </div> <!-- fin col-12 -->
                                    </section>



                                    <!-- Lista de materiales -->
                                    <section class="row mb-5">
                                        <div class="col-12">
                                            <div class="card bg-white p-4 shadow">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-boxes fa-2x me-3 text-primary"></i>
                                                    <h4 class="mb-0 fw-bold">Materiales que Puedes Reutilizar</h4>
                                                </div>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">♻️ Botellas plásticas</li>
                                                    <li class="list-group-item">👕 Ropa vieja o rota</li>
                                                    <li class="list-group-item">📦 Cajas de cartón</li>
                                                    <li class="list-group-item">🥫 Latas de alimentos</li>
                                                    <li class="list-group-item">📰 Papel y revistas</li>
                                                    <li class="list-group-item">🧦 Calcetines sin par</li>
                                                    <li class="list-group-item">💿 Discos compactos (CD/DVD)</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </section>

                                    <section class="row mb-5">
                                        <div class="col-12">
                                            <div class="card bg-white p-4 shadow">
                                                <div class="d-flex align-items-center mb-3">
                                                    <i class="fas fa-paint-brush fa-2x me-3 text-info"></i>
                                                    <h4 class="mb-0 fw-bold">Instrucciones para Decorar un Objeto Reutilizado</h4>
                                                </div>
                                                <ol class="ps-3">
                                                    <li>Elige un objeto que ya no uses (botella, lata, cartón).</li>
                                                    <li>Límpialo bien y déjalo secar.</li>
                                                    <li>Pinta o decóralo con papel, colores, o stickers.</li>
                                                    <li>Dale un nuevo uso como lapicero, maceta o caja organizadora.</li>
                                                </ol>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                                <!-- Botón flotante para volver arriba (REUTILIZAR) -->
                                <button onclick="topFunctionReutilizar()" id="btnTopReutilizar" class="btn btn-primary rounded-circle shadow-lg"
                                        style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; display: none; border: none;">
                                    <i class="fas fa-arrow-up fa-lg"></i>
                                </button>
                            </div>
                        @endif

                        <div class="mt-5 animate__animated animate__fadeInUp">
                            <a href="{{ route('talleres.index') }}" class="btn btn-dark btn-lg btn-hover">
                                <i class="fas fa-sign-out-alt icon-animate"></i> Regresar
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dependencias -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>

        /* Estilos generales */
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .btn-hover:hover {
            transform: scale(1.05);
        }
        .home-background {
            animation: subtleBackground 15s infinite alternate;
        }
        @keyframes subtleBackground {
            0% { background-position: center; }
            100% { background-position: 20% center; }
        }
        .card {
            padding: 25px 15px !important;
        }
        .card h4 {
            margin-bottom: 15px;
        }
        .card p {
            margin-bottom: 20px;
        }
        .icon-animate {
            transition: all 0.5s ease;
        }
        .book-animate {
            animation: bookFlip 3s infinite ease-in-out;
        }
        .pencil-animate {
            animation: pencilWrite 2s infinite alternate;
        }
        .gamepad-animate {
            animation: gamepadVibrate 1.5s infinite;
        }
        .star-animate {
            animation: starPulse 2s infinite alternate;
        }
        .logout-animate {
            animation: rotateLogout 4s infinite linear;
        }
        @keyframes bookFlip {
            0%, 100% { transform: rotateY(0deg); }
            50% { transform: rotateY(20deg); }
        }
        @keyframes pencilWrite {
            0% { transform: rotate(0deg) translateX(0); }
            100% { transform: rotate(5deg) translateX(5px); }
        }
        @keyframes gamepadVibrate {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px) rotate(-5deg); }
            75% { transform: translateX(3px) rotate(5deg); }
        }
        @keyframes starPulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.2); opacity: 1; text-shadow: 0 0 10px gold; }
        }
        @keyframes rotateLogout {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Estilos de pestañas */
        .nav-tabs {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #fff;
            border-bottom: 2px solid #dee2e6;
            justify-content: center;
            margin-bottom: 20px;
        }
        .nav-tabs .nav-link {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-bottom: none;
            border-radius: 0.5rem 0.5rem 0 0;
            margin-right: 0.5rem;
            padding: 0.75rem 1.5rem;
            color: #495057;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-tabs .nav-link:hover {
            background-color: #e9ecef;
        }
        .nav-tabs .nav-link.active {
            background-color: #fff;
            border-top: 3px solid #007bff;
            border-bottom: 2px solid #fff;
            color: #007bff;
        }
        .tab-content {
            background-color: transparent;
            padding: 1rem;
        }

        /* Animación del contenedor */
        .contenido-centro {
            transition: all 0.5s ease;
            max-width: 950px;
            min-height: 80vh;
            margin: 0 auto;
            padding: 2rem;
        }
        .contenido-centro.tab-agua {
            max-width: 1200px;
            min-height: 10vh;
        }

        /* Estilos para la navegación interna */
        .scroll-margin-top {
            scroll-margin-top: 120px;
        }

        /* Estilo para enlaces activos */
        .navbar-nav .nav-link.active {
            font-weight: bold;
            background-color: rgba(255,255,255,0.2);
            border-radius: 5px;
        }

        /* Efecto smooth al desplazarse */
        html {
            scroll-behavior: smooth;
        }

        /* Efecto hover para imágenes */
        .hover-zoom {
            transition: transform 0.3s ease;
        }
        .hover-zoom:hover {
            transform: scale(1.03);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Estilo para las tarjetas */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }

        /* Botón flotante */
        #btnTop {
            transition: all 0.3s ease;
        }
        #btnTop:hover {
            transform: translateY(-3px);
            background-color: #0b5ed7 !important;
        }

        /* Estilos para el margen del mensaje de bienvenida */
        .welcome-message {
            margin-top: 60px; /* Default para el mensaje principal */
        }

        /* Asegurar que la pestaña Inicio tenga el margen correcto */
        #tab-inicio .welcome-message {
            margin-top: 60px;
        }

        /* Aplicar margin-top: 1000px solo en la pestaña Agua */
        .tab-agua-active {
            margin-top: 3400px;
        }

        /* Responsividad */
        @media (max-width: 576px) {
            .contenido-centro {
                max-width: 95% !important;
                padding: 1rem !important;
            }
            .contenido-centro.tab-agua {
                max-width: 95% !important;
                min-height: 100vh;
            }
            .nav-tabs {
                flex-direction: column;
            }
            .nav-tabs .nav-link {
                margin-right: 0;
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
            }
            .display-4 {
                font-size: 2rem;
            }
            .card h4 {
                font-size: 1.3rem;
            }
            .card p {
                font-size: 1rem;
            }

        }
        @media (max-width: 768px) {
            .contenido-centro {
                max-width: 90% !important;
                padding: 1.5rem !important;
            }
            .contenido-centro.tab-agua {
                max-width: 90% !important;
                min-height: 100vh;
            }

        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('#alumnoTabs .nav-link');
            const contenidoPrincipal = document.querySelector('.contenido-principal');
            const contenidoCentro = document.querySelector('.contenido-centro');

            tabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function (e) {
                    // Añadir o remover la clase tab-agua-active según la pestaña activa
                    if (e.target.id === 'agua-tab' || e.target.id === 'reutilizar-tab' ) {
                        contenidoPrincipal.classList.add('tab-agua-active');
                        contenidoCentro.classList.add('tab-agua');
                    } else {
                        contenidoPrincipal.classList.remove('tab-agua-active');
                        contenidoCentro.classList.remove('tab-agua');
                    }

                    // Desplazar al inicio del contenedor principal en todas las pestañas
                    contenidoPrincipal.scrollIntoView({ behavior: 'instant', block: 'start' });
                });
            });

            // Activar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Mostrar/ocultar botón de subir
            window.onscroll = function() {
                scrollFunction();
                scrollFunctionReutilizar();
                updateActiveNavLink();
                updateActiveNavLinkReutilizar();
            };
        });


        function scrollFunction() {
            const btnTop = document.getElementById("btnTop");
            if (btnTop) {
                if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                    btnTop.style.display = "block";
                } else {
                    btnTop.style.display = "none";
                }
            }
        }

        function scrollFunctionReutilizar() {
            const btnTopReutilizar = document.getElementById("btnTopReutilizar");
            if (btnTopReutilizar) {
                if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                    btnTopReutilizar.style.display = "block";
                } else {
                    btnTopReutilizar.style.display = "none";
                }
            }
        }

        function topFunction() {
            const seccionBienvenida = document.getElementById('seccion-bienvenida');
            if (seccionBienvenida) {
                seccionBienvenida.scrollIntoView({behavior: 'smooth'});
            }
        }

        function topFunctionReutilizar() {
            const seccionBienvenida = document.getElementById('seccion-bienvenida-reutilizar');
            if (seccionBienvenida) {
                seccionBienvenida.scrollIntoView({behavior: 'smooth'});
            }
        }

        // Actualizar enlace activo según scroll (para Agua)
        function updateActiveNavLink() {
            const internalNav = document.getElementById('internalNav');
            if (internalNav) {
                const sections = document.querySelectorAll('#tab-agua section[id]');
                let scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 120;
                    const sectionHeight = section.offsetHeight;
                    const sectionId = section.getAttribute('id');

                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        document.querySelectorAll('#internalNav a').forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${sectionId}`) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            }
        }

        // Actualizar enlace activo según scroll (para Reutilizar)
        function updateActiveNavLinkReutilizar() {
            const internalNavReutilizar = document.getElementById('internalNavReutilizar');
            if (internalNavReutilizar) {
                const sections = document.querySelectorAll('#tab-reutilizar section[id]');
                let scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 120;
                    const sectionHeight = section.offsetHeight;
                    const sectionId = section.getAttribute('id');

                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        document.querySelectorAll('#internalNavReutilizar a').forEach(link => {
                            link.classList.remove('active');
                            if (link.getAttribute('href') === `#${sectionId}`) {
                                link.classList.add('active');
                            }
                        });
                    }
                });
            }
        }

        // Click en enlaces de navegación (Agua)
        document.querySelectorAll('#internalNav a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('#internalNav a').forEach(el => el.classList.remove('active'));
                this.classList.add('active');

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Click en enlaces de navegación (Reutilizar)
        document.querySelectorAll('#internalNavReutilizar a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('#internalNavReutilizar a').forEach(el => el.classList.remove('active'));
                this.classList.add('active');

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>



@endsection
