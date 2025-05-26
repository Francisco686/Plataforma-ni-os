@extends('layouts.customHome')

@section('content')
    <div class="container-fluid p-0 home-background" style="background-size: cover; background-position: center; min-height: 100vh; margin: 0; padding: 0;">
        <div class="row no-gutters" style="min-height: 100vh; margin: 0;">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="w-100 px-3 px-md-5 contenido-principal">
                    <div class="text-center welcome-message" style="margin-top: 60px;">
                        <div class="animate__animated animate__fadeInDown">
                            <h1 class="text-white font-weight-bold mb-3"><strong>¡Bienvenid@, {{ Auth::user()->name }}!</strong></h1>

                            @if(Auth::user()->role === 'alumno' && Auth::user()->grupo)
                                <div class="alert alert-info text-center mb-4">
                                    Tu grupo es: <strong>{{ Auth::user()->grupo->grado }}°{{ strtoupper(Auth::user()->grupo->grupo) }}</strong>
                                </div>
                            @endif

                            <p class="lead text-white mb-5"><strong>Explora tus juegos.</strong></p>
                        </div>



                        @if(Auth::user()->role === 'alumno')
                            <!-- Pestañas para alumnos -->
                            <ul class="nav nav-tabs mb-4" id="alumnoTabs">
                                <li class="nav-item">
                                    <a class="nav-link "  href="{{ route('home') }}" >Regresar al inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="agua-tab" data-bs-toggle="tab" href="#tab-agua" role="tab">Agua</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="reciclaje-tab" data-bs-toggle="tab" href="#tab-reciclaje" role="tab">Reciclaje</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="reutilizar-tab" data-bs-toggle="tab" href="#tab-reutilizar" role="tab">Reutilizar</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="alumnoTabContent">

                                <!-- Pestaña Agua -->
                                <div class="tab-pane fade" id="tab-agua" role="tabpanel">
                                    <!-- Sección Bienvenida -->
                                    <section id="seccion-bienvenida" class="scroll-margin-top py-4" style="scroll-margin-top: 100px;">
                                        <!-- Título de la zona de juegos -->
                                        <div class="text-center mb-5">
                                            <h2 class="fw-bold text-primary display-4 " style="font-size: 3rem; font-weight: 700;" >Zona de Juegos</h2>
                                            <p class="text-muted" style="font-size: 1.2rem;">Recuerda los íconos ecológicos y empareja las tarjetas. ¡Diviértete aprendiendo sobre el medio ambiente!</p>
                                        </div>

                                        <!-<!-- Contenedor de las tarjetas de juego con el diseño de recuadro -->
                                        <div class="contenido-centro">
                                            <div id="game-board" class="game-container d-flex flex-wrap justify-content-center gap-4 mb-5">
                                                <!-- Las tarjetas se generarán dinámicamente con JavaScript -->
                                            </div>

                                            <!-- Mensaje de resultado cuando el juego termine -->
                                            <div id="game-result" class="text-center" style="display: none;">
                                                <h3 class="fw-bold text-success">¡Felicidades!</h3>
                                                <p class="fs-4 text-muted">Has completado el juego con éxito. ¡Recuerda siempre cuidar el medio ambiente!</p>
                                                <button id="restart-button" class="btn btn-primary">Reiniciar Juego</button>
                                            </div>
                                        </div>
                                    </section>
                                </div>


                                <!-- Pestaña Reciclaje -->
                                <div class="tab-pane fade" id="tab-reciclaje" role="tabpanel">
                                    <div class="animate__animated animate__fadeIn">
                                        <h3 class="text-white text-center mb-4">Reciclaje</h3>
                                        <div class="card bg-white text-dark p-4">
                                            <p>¡Pronto tendrás información sobre reciclaje aquí!</p>
                                        </div>
                                    </div>
                                </div>


                                <!-- Pestaña Reutilizar -->
                                <div class="tab-pane fade" id="tab-reutilizar" role="tabpanel">
                                    <!-- Sección de bienvenida -->
                                    <section id="seccion-bienvenida-reutilizar" class="mb-5 scroll-margin-top" style="scroll-margin-top: 100px;">
                                        <meta name="csrf-token" content="{{ csrf_token() }}">

                                        <!-- 🎮 Juego Taller Creativo -->
                                        <section id="taller-creativo" class="mt-4">
                                            <div class="card bg-light text-dark p-4 shadow">
                                                <h5 class="fw-bold mb-3">🎮 Taller Creativo</h5>
                                                <p>Selecciona dos materiales y crea algo nuevo con ellos.</p>

                                                <!-- Botones de materiales -->
                                                <div class="mb-3 d-flex flex-wrap gap-2">
                                                    <button class="btn btn-outline-primary" onclick="toggleMaterial('botella')">Botella</button>
                                                    <button class="btn btn-outline-success" onclick="toggleMaterial('ropa')">Ropa Vieja</button>
                                                    <button class="btn btn-outline-warning" onclick="toggleMaterial('cartón')">Cartón</button>
                                                    <button class="btn btn-outline-secondary" onclick="toggleMaterial('lata')">Lata</button>
                                                    <button class="btn btn-outline-info" onclick="toggleMaterial('cd')">CD Viejo</button>
                                                </div>

                                                <!-- Imágenes de materiales seleccionados -->
                                                <div id="selectedImages" class="d-flex flex-wrap gap-3 mt-3"></div>

                                                <!-- Botón para crear el objeto -->
                                                <button class="btn btn-dark mt-3" onclick="combineMaterials()">Crear Objeto</button>

                                                <!-- Resultado del objeto creado -->
                                                <div id="resultArea" class="mt-4 d-none">
                                                    <h5 id="resultTitle" class="fw-bold"></h5>
                                                    <img id="resultImage" src="" alt="Imagen del objeto creado" class="img-fluid my-3 rounded shadow" style="max-width: 300px;">
                                                    <p id="resultDescription"></p>
                                                </div>
                                            </div>
                                        </section>

                                        <!-- Scripts del juego -->
                                        <script>
                                            let selected = [];

                                            function toggleMaterial(material) {
                                                const images = {
                                                    'botella': '/images/materiales/botella.png',
                                                    'ropa': '/images/materiales/ropa.png',
                                                    'cartón': '/images/materiales/carton.png',
                                                    'lata': '/images/materiales/lata.png',
                                                    'cd': '/images/materiales/cd.png'
                                                };

                                                if (selected.includes(material)) {
                                                    selected = selected.filter(m => m !== material);
                                                } else if (selected.length < 2) {
                                                    selected.push(material);
                                                }

                                                const selectedImagesDiv = document.getElementById('selectedImages');
                                                selectedImagesDiv.innerHTML = '';
                                                selected.forEach(mat => {
                                                    const img = document.createElement('img');
                                                    img.src = images[mat];
                                                    img.alt = mat;
                                                    img.style.maxWidth = '120px';
                                                    img.className = 'rounded shadow';
                                                    selectedImagesDiv.appendChild(img);
                                                });

                                                console.log("Seleccionados:", selected);
                                            }

                                            function combineMaterials() {
                                                if (selected.length !== 2) {
                                                    alert("Selecciona exactamente 2 materiales.");
                                                    return;
                                                }

                                                fetch("{{ url('/workshop/combine') }}", {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type': 'application/json',
                                                        'X-CSRF-TOKEN': document.querySelector('meta[name=\"csrf-token\"]').getAttribute('content')
                                                    },
                                                    body: JSON.stringify({ materials: selected })
                                                })
                                                    .then(response => {
                                                        if (!response.ok) {
                                                            throw new Error('Respuesta del servidor no válida.');
                                                        }
                                                        return response.json();
                                                    })
                                                    .then(data => {
                                                        document.getElementById('resultTitle').textContent = data.title;
                                                        document.getElementById('resultImage').src = data.image;
                                                        document.getElementById('resultDescription').textContent = data.description;
                                                        document.getElementById('resultArea').classList.remove('d-none');

                                                        selected = [];
                                                        document.getElementById('selectedImages').innerHTML = '';
                                                    })
                                                    .catch(error => {
                                                        console.error("Error al combinar materiales:", error);
                                                        alert("Ocurrió un error al combinar los materiales. Intenta de nuevo.");
                                                        selected = [];
                                                        document.getElementById('selectedImages').innerHTML = '';
                                                    });
                                            }
                                        </script>
                                    </section>
                                </div>



                                @endif

                        <div class="mt-5 animate__animated animate__fadeInUp">
                            <a href="{{ route('logout') }}" class="btn btn-dark btn-lg btn-hover"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt icon-animate"></i> Cerrar Sesión
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

        .game-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            justify-content: center;
            max-width: 1000px;
            margin: 0 auto;
        }

        .game-card {
            width: 120px;
            height: 120px;
            background-color: #f0f0f0;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
            position: relative;
        }

        .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: #ddd;
            border-radius: 8px;
        }

        .card-image {
            max-width: 100%;
            max-height: 100%;
            display: none;
            transition: transform 0.3s ease;
        }

        .game-card.flipped .card-image {
            display: block;
        }

        .game-card.flipped .card-back {
            display: none;
        }

        #game-result {
            display: none;
            margin-top: 50px;
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }

        /* Estilos del botón de regreso */
        .btn-back {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1000;
        }
    </style>

    <!-- Script JavaScript para la lógica del juego -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Configuración del juego
            const cardImages = [
                { id: 1, src: "{{ asset('img/reciclaje.jpg') }}", alt: "Reciclaje" },
                { id: 2, src: "{{ asset('img/agua.png') }}", alt: "Agua" },
                { id: 3, src: "{{ asset('img/energia.png') }}", alt: "Energía" },
                { id: 4, src: "{{ asset('img/arbol.png') }}", alt: "Árbol" }
            ];

            let flippedCards = [];
            let matchedPairs = 0;
            const gameBoard = document.getElementById('game-board');
            const gameResult = document.getElementById('game-result');
            const restartButton = document.getElementById('restart-button');

            // Inicializar el juego
            initGame();

            function initGame() {
                // Limpiar el tablero
                gameBoard.innerHTML = '';
                flippedCards = [];
                matchedPairs = 0;
                gameResult.style.display = 'none';

                // Crear un mazo de cartas (2 de cada imagen)
                let cards = [];
                cardImages.forEach(image => {
                    cards.push({...image});
                    cards.push({...image});
                });

                // Mezclar las cartas
                cards = shuffleArray(cards);

                // Crear las cartas en el DOM
                cards.forEach((card, index) => {
                    const cardElement = document.createElement('div');
                    cardElement.className = 'game-card';
                    cardElement.dataset.id = card.id;
                    cardElement.dataset.index = index;

                    cardElement.innerHTML = `
                        <div class="card-back"></div>
                        <img src="${card.src}" alt="${card.alt}" class="card-image" />
                    `;

                    cardElement.addEventListener('click', flipCard);
                    gameBoard.appendChild(cardElement);
                });
            }

            // Función para mezclar array (Fisher-Yates algorithm)
            function shuffleArray(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }

            // Función para voltear una carta
            function flipCard() {
                // Solo permitir voltear si hay menos de 2 cartas volteadas y no está ya volteada
                if (flippedCards.length < 2 && !this.classList.contains('flipped')) {
                    this.classList.add('flipped');
                    flippedCards.push(this);

                    // Cuando tenemos 2 cartas volteadas
                    if (flippedCards.length === 2) {
                        const [card1, card2] = flippedCards;

                        // Verificar si coinciden
                        if (card1.dataset.id === card2.dataset.id) {
                            // Son un par, las dejamos volteadas
                            flippedCards = [];
                            matchedPairs++;

                            // Verificar si se han encontrado todos los pares
                            if (matchedPairs === cardImages.length) {
                                // Mostrar mensaje de finalización después de un pequeño retraso
                                setTimeout(() => {
                                    gameResult.style.display = 'block';
                                }, 500);
                            }
                        } else {
                            // No coinciden, las volteamos de nuevo después de un breve retraso
                            setTimeout(() => {
                                card1.classList.remove('flipped');
                                card2.classList.remove('flipped');
                                flippedCards = [];
                            }, 1000);
                        }
                    }
                }
            }

            // Reiniciar el juego cuando el botón es presionado
            restartButton.addEventListener('click', initGame);
        });
    </script>
@endsection
