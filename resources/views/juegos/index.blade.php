@extends('layouts.customHome')

@section('content')


    <div class="container py-5 position-relative">
        <!-- Emojis flotantes -->
        <div class="emoji emoji1">🐸</div>
        <div class="emoji emoji2">🧠</div>
        <div class="emoji emoji3">🦋</div>
        <div class="emoji emoji4">🌿</div>

        <!-- Bienvenida destacada -->
        <div class="welcome-box mx-auto text-center p-4 mb-5 animate__animated animate__fadeInDown">
            <h2 class="fw-bold text-success mb-2 display-5">🎮 ¡Bienvenido a la Zona de Juegos!</h2>
            <p class="text-dark fs-5">Explora juegos mágicos que te enseñan a cuidar el planeta 🌎💚</p>
        </div>

        <!-- Tarjetas de Juegos -->
        <div class="row g-5 justify-content-center">
            <!-- Juego 1 -->
            <div class="col-md-4 col-sm-6 d-flex">
                <div class="card juego-card text-center shadow-lg w-100 d-flex flex-column">
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <div class="emoji-juego mb-2">🧠</div>
                            <h5 class="fw-bold text-success fs-4">Memorama Ecológico</h5>
                            <p class="text-muted">¡Encuentra los pares de tarjetas ecológicas!</p>
                        </div>
                        <a href="{{ url('/juegos/memorama') }}" class="btn btn-outline-success rounded-pill mt-3">
                            Jugar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Juego 2 -->
            <div class="col-md-4 col-sm-6 d-flex">
                <div class="card juego-card text-center shadow-lg w-100 d-flex flex-column">
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <div class="emoji-juego mb-2">🔤✨</div>
                            <h5 class="fw-bold text-primary fs-4">Sopa de Letras</h5>
                            <p class="text-muted">¡Encuentra palabras mágicas sobre la naturaleza!</p>
                        </div>
                        <a href="{{ url('/juegos/sopa') }}" class="btn btn-outline-primary rounded-pill mt-3">
                            Jugar
                        </a>
                    </div>
                </div>
            </div>

            <!-- Juego 3 -->
            <div class="col-md-4 col-sm-6 d-flex">
                <div class="card juego-card text-center shadow-lg w-100 d-flex flex-column">
                    <div class="card-body d-flex flex-column justify-content-between p-4">
                        <div>
                            <div class="emoji-juego mb-2" style="font-size: 2.5rem;">🧩🛠️</div>
                            <h5 class="fw-bold text-success fs-4">Combinaciones</h5>
                            <p class="text-muted">¡Combina materiales reciclables para crear objetos increíbles!</p>
                        </div>
                        <a href="{{ route('juegos.combinar') }}" class="btn btn-outline-success rounded-pill mt-3">
                            Jugar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Separación -->
        <div class="my-5 text-center">
            <hr class="w-50 mx-auto" style="border-top: 3px dashed #28a745;">
            <h5 class="text-muted mt-4">¡Más juegos para ti!</h5>
        </div>

        <!-- Juegos de abajo -->
        <div class="col-md-4 col-sm-6 d-flex">
            <div class="card juego-card text-center shadow-lg w-100 d-flex flex-column">
                <div class="card-body d-flex flex-column justify-content-between p-4">
                    <div>
                        <div class="emoji-juego mb-2" style="font-size: 2.5rem;">♻️🚮</div>
                        <h5 class="fw-bold text-success fs-4">Clasificación de residuos</h5>
                        <p class="text-muted">Arrastra los objetos a los botes de reciclables y no reciclables.</p>
                    </div>
                    <a href="{{ route('juegos.clasificacion') }}" class="btn btn-outline-success rounded-pill mt-3">
                        Jugar
                    </a>
                </div>
            </div>
        </div>


        <!-- Botón regresar -->
        <div class="btn-back" style="position: fixed; top: 1rem; left: 1rem; z-index: 1000;">
            <a href="{{ route('home') }}" class="btn btn-success btn-md rounded-pill shadow-lg animate__animated animate__fadeInDown"
               style="font-size: 1.1rem; padding: 0.6rem 1.6rem;">
                <i class="fas fa-arrow-left me-2"></i> Regresar a Inicio
            </a>
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

    <!-- Estilos CSS -->
    <style>
        /* Diseño del recuadro con las propiedades indicadas */
        .contenido-centro {
            max-width: 1400px !important;
            height: auto !important;
            padding: 3rem !important;
            width: 100% !important;
            margin: 0 auto !important;
            position: static !important;
            transform: none !important;
            box-sizing: border-box;
            background-color: rgba(255, 255, 255, 0.2) !important;
            -webkit-backdrop-filter: blur(25px);
            backdrop-filter: blur(25px);
            border-radius: 1rem;
            pointer-events: auto !important;
        }

        <style>
         .welcome-box {
             background: #e0f7ec;
             border: 2px dashed #00c57d;
             border-radius: 1rem;
             box-shadow: 0 0 25px rgba(0, 195, 125, 0.2);
             max-width: 720px;
         }


        .juego-card {
            background: #ffffff;
            border-radius: 1rem;
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }

        .juego-card:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 25px rgba(0, 200, 255, 0.25);
        }

        .emoji-juego {
            font-size: 2.7rem;
            animation: bounce 1.5s infinite;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .emoji {
            position: absolute;
            font-size: 2rem;
            opacity: 0.3;
            animation: float 7s ease-in-out infinite;
            z-index: 0;
        }

        .emoji1 { top: 10%; left: 5%; }
        .emoji2 { top: 20%; right: 6%; }
        .emoji3 { bottom: 10%; left: 8%; }
        .emoji4 { bottom: 15%; right: 10%; }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @media (max-width: 768px) {
            .emoji {
                display: none;
            }

            .welcome-box {
                padding: 2rem 1rem;
            }

            h2.display-5 {
                font-size: 1.8rem;
            }
        }
    </style>
    <!-- Botón de sonido -->
    <div class="text-end me-4 mb-3">
        <button id="toggle-music" class="btn btn-outline-dark">
            🔈 Activar música
        </button>
    </div>


    <!-- Audio oculto -->
    <audio id="background-music" src="{{ asset('audio/bienvenida.mp3') }}" loop></audio>

    <script>
        const music = document.getElementById('background-music');
        const toggle = document.getElementById('toggle-music');
        let playing = false;

        toggle.addEventListener('click', () => {
            if (playing) {
                music.pause();
                toggle.innerText = '🔇 Activar música';
            } else {
                music.play();
                toggle.innerText = '🔊 Silenciar música';
            }
            playing = !playing;
        });
    </script>


    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
