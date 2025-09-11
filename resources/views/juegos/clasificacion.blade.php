@extends('layouts.app')

@section('content')
    <style>
        :root {
            --card-flip-duration: 0.6s;
        }

        body {
            background: linear-gradient(to bottom, #c6f3ff, #ffffff);
            overflow-x: hidden;
            position: relative;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        @if(Auth::user()->role === 'alumno')
        .background-animated {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .balloon {
            position: absolute;
            width: 60px;
            height: 90px;
            border-radius: 50% 50% 50% 50% / 60% 60% 40% 40%;
            animation: floatUp 8s linear infinite;
        }
        .balloon::after {
            content: '';
            position: absolute;
            bottom: -25px;
            left: 50%;
            width: 3px;
            height: 25px;
            background: #888;
            transform: translateX(-50%);
        }
        .balloon:nth-child(1) { left: 10%; animation-delay: 0s; background: radial-gradient(circle, #ff8eb8, #f14a72); }
        .balloon:nth-child(2) { left: 30%; animation-delay: 2s; background: radial-gradient(circle, #a4cafe, #2563eb); }
        .balloon:nth-child(3) { left: 70%; animation-delay: 1s; background: radial-gradient(circle, #ffd166, #f59e0b); }
        .balloon:nth-child(4) { left: 85%; animation-delay: 3s; background: radial-gradient(circle, #8ecae6, #3b82f6); }

        @keyframes floatUp {
            0% { bottom: -100px; opacity: 0.9; }
            100% { bottom: 110%; opacity: 0; }
        }

        .emoji {
            position: absolute;
            font-size: 2.8rem;
            opacity: 0.5;
            animation: float 20s ease-in-out infinite;
        }
        .emoji1 { top: 10%; left: 8%; animation-delay: 0s; }
        .emoji2 { top: 20%; right: 10%; animation-delay: 5s; }
        .emoji3 { bottom: 15%; left: 12%; animation-delay: 10s; }
        .emoji4 { bottom: 8%; right: 15%; animation-delay: 15s; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-40px); }
        }
        @endif

        h2 {
            font-size: 4rem;
            color: #0d6efd;
            font-weight: 900;
            text-shadow: 3px 3px #d0f0ff;
            margin-bottom: 3rem;
            text-align: center;

        }

        h4 {
            font-size: 2.2rem;
            font-weight: 700;
            text-shadow: 1px 1px #d0f0ff;
            margin-bottom: 1.5rem;
        }

        .game-card {
            border-radius: 2rem;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            padding: 3rem;
            width: 100%;
        }

        .game-card:hover {

            box-shadow: 0 12px 30px rgba(0, 123, 255, 0.3);
        }

        .card-text {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.2rem;
        }

        .btn-solid {
            color: #fff;
            font-weight: 600;
            padding: 0.9rem 2.2rem;
            border-radius: 1.2rem;
            border: none;
            transition: all 0.3s ease;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .btn-green { background-color: #22c55e; }
        .btn-green:hover { background-color: #15803d; transform: scale(1.05); }

        .btn-dark { background-color: #343a40; }
        .btn-dark:hover { background-color: #1a1e21; transform: scale(1.05); }

        .btn-back {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 1000;
        }

        #objetos-container {
            display: flex;
            justify-content: center; /* Center objects horizontally */
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .objeto {
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 5px;
            padding: 5px;
            border-radius: 5px;
            font-size: 0.9rem;
            white-space: nowrap;
            z-index: 20;
            background-color: #f8f9fa;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .objeto img {
            max-width: 80%;
            max-height: 80%;
            object-fit: contain;
        }

        .objeto.dragging {
            opacity: 0.8;
            cursor: grabbing;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .bote {
            position: relative;
            border-radius: 12px;
            background-color: #e9ecef;
            box-shadow: inset 0 5px 10px rgba(0,0,0,0.1);
            min-height: 350px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }

        .bote.reutilizable {
            border: 3px solid #198754;
            background-color: #d1e7dd;
        }
        .bote.no-reutilizable {
            border: 3px solid #dc3545;
            background-color: #f8d7da;
        }

        .bote h4 {
            margin-bottom: 10px;
            font-weight: 700;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .bote .mensaje {
            margin-top: 8px;
            font-weight: 600;
            color: #555;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .drop-area {
            flex: 1;
            width: 90%;
            margin-top: 15px;
            padding-bottom: 60px;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            align-content: flex-start;
            overflow-y: auto;
            min-height: 180px;
            border-radius: 12px;
            border: 2px dashed transparent;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }
        .drop-area.dragover {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
        }

        .bote-svg-button {
            position: relative;
            width: 120px;
            height: 140px;
            margin-top: 10px;
            background: transparent;
            border: none;
            padding: 0;
        }
        .trash-svg {
            width: 100%;
            height: 100%;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }

        #mensaje-error {
            position: relative;
            margin: 20px auto;
            text-align: center;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(220, 53, 69, 0.4);
            width: 100%;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
            background-color: #f8d7da;
            color: #842029;
            font-weight: bold;
            display: none;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        #mensaje-final {
            display: none;
            text-align: center;
            font-size: 1.5rem;
            margin: 30px 0;
            padding: 1.5rem;
            background-color: #d1e7dd;
            border-radius: 15px;
            color: #0f5132;
            border: 2px solid #badbcc;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        #contador-rondas {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: #495057;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .timer {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: bold;
        }

        .modal-custom {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .modal-content {
            position: relative;
            background-color: white;
            border-radius: 2rem;
            padding: 2.5rem;
            text-align: center;
            z-index: 2;
            box-shadow: 0 12px 30px rgba(0, 123, 255, 0.3);
            border: 2px dashed #ddd;
            max-width: 600px;
            width: 90%;
            animation: zoomIn 0.5s ease;
        }

        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-content h3 {
            font-size: 2rem;
            color: #22c55e;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .modal-content p {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 1.5rem;
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 3rem;
            }

            .game-card {
                padding: 2rem;
            }

            .objeto img {
                max-height: 70px;
            }

            .bote {
                min-height: 300px;
            }

            .btn-solid {
                font-size: 1.1rem;
                padding: 0.7rem 1.8rem;
            }

            .modal-content {
                padding: 1.5rem;
            }

            .modal-content h3 {
                font-size: 1.5rem;
            }

            .modal-content p {
                font-size: 1rem;
            }

            .emoji {
                display: none;
            }
        }
    </style>

    @if(Auth::user()->role === 'alumno')
        <div class="background-animated">

            <div class="emoji emoji1">🎮</div>
            <div class="emoji emoji2">🧩</div>
            <div class="emoji emoji3">🔤</div>
            <div class="emoji emoji4">♻️</div>
        </div>
    @endif

    <div class="container-fluid py-5" style="min-height: 100vh; position: relative; z-index: 1;">
        <div class="btn-back">
            <a href="{{ route('juegos.index') }}" class="btn btn-solid btn-green">
                <i class="fas fa-arrow-left me-2"></i> Regresar a Inicio
            </a>
        </div>

        <h2>🎯 ¡Clasifica los materiales en su bote correcto! 🗑♻</h2>

        <div class="timer" id="timer">Tiempo: 0s</div>

        <div class="row justify-content-center">
            <div class="col-md-10 col-sm-12">
                <div class="game-card">
                    <div id="contador-rondas">Ronda 1 de 5</div>

                    <div id="mensaje-error">
                        ❌ ¡Ups! Ese objeto no va en este bote. Intenta de nuevo.
                    </div>

                    <div id="mensaje-final">
                        ¡Felicidades! Has completado todas las rondas del juego.
                    </div>

                    <div id="objetos-container" aria-label="Objetos para clasificar"></div>

                    <button id="nueva-ronda-btn" class="btn btn-solid btn-green">Nueva Ronda</button>

                    <div class="row g-4">
                        <div id="reutilizables" class="bote reutilizable col-md-6 col-sm-12" aria-label="Contenedor de objetos reutilizables">
                            <h4>Reutilizables ♻️</h4>
                            <div class="drop-area" aria-label="Área para objetos reutilizables"></div>
                            <button class="delete-button bote-svg-button" aria-label="Bote reutilizable">
                                <svg class="trash-svg" viewBox="0 -10 64 74" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                                    <g id="trash-can">
                                        <rect x="16" y="24" width="32" height="30" rx="3" ry="3" fill="#198754"></rect>
                                        <g id="lid-group">
                                            <rect x="12" y="12" width="40" height="6" rx="2" ry="2" fill="#146c43"></rect>
                                            <rect x="26" y="8" width="12" height="4" rx="2" ry="2" fill="#146c43"></rect>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                            <div class="mensaje">Arrastra aquí los objetos reutilizables</div>
                        </div>

                        <div id="no-reutilizables" class="bote no-reutilizable col-md-6 col-sm-12" aria-label="Contenedor de objetos no reutilizables">
                            <h4>No reutilizables 🗑️</h4>
                            <div class="drop-area" aria-label="Área para objetos no reutilizables"></div>
                            <button class="delete-button bote-svg-button" aria-label="Bote no reutilizable">
                                <svg class="trash-svg" viewBox="0 -10 64 74" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                                    <g id="trash-can">
                                        <rect x="16" y="24" width="32" height="30" rx="3" ry="3" fill="#dc3545"></rect>
                                        <g id="lid-group">
                                            <rect x="12" y="12" width="40" height="6" rx="2" ry="2" fill="#b02a37"></rect>
                                            <rect x="26" y="8" width="12" height="4" rx="2" ry="2" fill="#b02a37"></rect>
                                        </g>
                                    </g>
                                </svg>
                            </button>
                            <div class="mensaje">Arrastra aquí los objetos no reutilizables</div>
                        </div>
                    </div>

                    <div id="result-modal" class="modal-custom d-none">
                        <div class="modal-overlay"></div>
                        <div class="modal-content">
                            <h3 id="modal-result-title">🎉 ¡Juego Completado!</h3>
                            <p id="modal-result-message"></p>
                            <p id="tiempo-final">Tiempo: 0s</p>
                            <button onclick="closeModal()" class="btn btn-solid btn-dark mt-3">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const objetosPorRonda = [
            [
                { nombre: "Botella", tipo: "reutilizable", imagen: "/assets/images/botella.png" },
                { nombre: "Papel sucio", tipo: "no-reutilizable", imagen: "/assets/images/papel-sucio.png" },
                { nombre: "Lata", tipo: "reutilizable", imagen: "/assets/images/lata.png" },
                { nombre: "Plástico", tipo: "reutilizable", imagen: "/assets/images/plastico.png" },
                { nombre: "Cartón", tipo: "reutilizable", imagen: "/assets/images/carton.png" },
                { nombre: "Ropa vieja", tipo: "reutilizable", imagen: "/assets/images/ropa.png" },
                { nombre: "CD", tipo: "reutilizable", imagen: "/assets/images/cd.png" },
                { nombre: "Vidrio", tipo: "reutilizable", imagen: "/assets/images/vidrio.png" },
                { nombre: "Bolsa de basura", tipo: "no-reutilizable", imagen: "/assets/images/bolsa-basura.png" }
            ],
            [
                { nombre: "Periódico", tipo: "reutilizable", imagen: "/assets/images/periodico.jpg" },
                { nombre: "Envase de yogur", tipo: "reutilizable", imagen: "/assets/images/yogur.jpg" },
                { nombre: "Jarra de vidrio", tipo: "reutilizable", imagen: "/assets/images/jarra.jpg" },
                { nombre: "Pañal usado", tipo: "no-reutilizable", imagen: "/assets/images/pañal.jpg" },
                { nombre: "Tetra pack", tipo: "reutilizable", imagen: "/assets/images/tetra-pack.jpg" },
                { nombre: "Cepillo de dientes", tipo: "no-reutilizable", imagen: "/assets/images/cepillo.jpg" },
                { nombre: "Libro viejo", tipo: "reutilizable", imagen: "/assets/images/libro.jpg" },
                { nombre: "Cáscara de plátano", tipo: "no-reutilizable", imagen: "/assets/images/cascara_platano.png" },
                { nombre: "Bote de aluminio", tipo: "reutilizable", imagen: "/assets/images/bote.png" },
                { nombre: "Pila gastada", tipo: "no-reutilizable", imagen: "/assets/images/pila.jpg" }
            ],
            [
                { nombre: "Revista", tipo: "reutilizable", imagen: "/assets/images/revista.png" },
                { nombre: "Vaso desechable", tipo: "no-reutilizable", imagen: "/assets/images/vaso.png" },
                { nombre: "Frascos de mermelada", tipo: "reutilizable", imagen: "/assets/images/mermelada.png" },
                { nombre: "Colilla de cigarro", tipo: "no-reutilizable", imagen: "/assets/images/cigarro.png" },
                { nombre: "Caja de zapatos", tipo: "reutilizable", imagen: "/assets/images/caja.png" },
                { nombre: "Chicle", tipo: "no-reutilizable", imagen: "/assets/images/chicle.png" },
                { nombre: "Bandeja de aluminio", tipo: "reutilizable", imagen: "/assets/images/bandeja.png" },
                { nombre: "Rastrillo", tipo: "no-reutilizable", imagen: "/assets/images/rastrillo.png" },
                { nombre: "Bolsas de tela", tipo: "reutilizable", imagen: "/assets/images/bolsa.png" },
                { nombre: "Semillas de manzana", tipo: "no-reutilizable", imagen: "/assets/images/manzana.png" }
            ],
            [
                { nombre: "Cajas de cereal", tipo: "reutilizable", imagen: "/assets/images/caja_c.png" },
                { nombre: "Pañuelos usados", tipo: "no-reutilizable", imagen: "/assets/images/pañuelo.png" },
                { nombre: "Botellas de shampoo", tipo: "reutilizable", imagen: "/assets/images/shampoo.png" },
                { nombre: "Esponja de cocina", tipo: "no-reutilizable", imagen: "/assets/images/esponja.png" },
                { nombre: "Latas de conserva", tipo: "reutilizable", imagen: "/assets/images/lata_c.png" },
                { nombre: "Cinta adhesiva", tipo: "no-reutilizable", imagen: "/assets/images/cinta.png" },
                { nombre: "Botes de pintura", tipo: "no-reutilizable", imagen: "/assets/images/pintura.png" },
                { nombre: "Filtros de café usados", tipo: "no-reutilizable", imagen: "/assets/images/cafe.png" },
                { nombre: "Bidones de agua", tipo: "reutilizable", imagen: "/assets/images/garrafon.png" },
                { nombre: "Papel de aluminio usado", tipo: "no-reutilizable", imagen: "/assets/images/aluminio.png" }
            ],
            [
                { nombre: "Botes de leche", tipo: "reutilizable", imagen: "/assets/images/leche.png" },
                { nombre: "Cepillo de pelo roto", tipo: "no-reutilizable", imagen: "/assets/images/cepillo_roto.png" },
                { nombre: "Frascos de perfume", tipo: "reutilizable", imagen: "/assets/images/perfume.png" },
                { nombre: "Hisopos usados", tipo: "no-reutilizable", imagen: "/assets/images/hisopos.png" },
                { nombre: "Cajas de pizza limpias", tipo: "reutilizable", imagen: "/assets/images/pizza.png" },
                { nombre: "Cubiertos de plástico", tipo: "no-reutilizable", imagen: "/assets/images/cubiertos.png" },
                { nombre: "Botes de conserva", tipo: "reutilizable", imagen: "/assets/images/botella.png" },
                { nombre: "Papel de regalo usado", tipo: "no-reutilizable", imagen: "/assets/images/regalo.png" },
                { nombre: "Bolsas de papel", tipo: "reutilizable", imagen: "/assets/images/bolsa_papel.png" },
                { nombre: "Cápsulas de café usadas", tipo: "no-reutilizable", imagen: "/assets/images/capsulas.png" }
            ]
        ];

        let rondaActual = 0;
        let errorCount = 0;
        let startTime = null;
        let timerInterval = null;
        let hasStarted = false;
        const totalRondas = 5;
        let objetosEnJuego = [];
        const objetosContainer = document.getElementById('objetos-container');
        const nuevaRondaBtn = document.getElementById('nueva-ronda-btn');
        const contadorRondas = document.getElementById('contador-rondas');
        const mensajeFinal = document.getElementById('mensaje-final');
        const resultModal = document.getElementById('result-modal');
        const modalResultMessage = document.getElementById('modal-result-message');
        const tiempoFinal = document.getElementById('tiempo-final');
        const dropAreas = document.querySelectorAll('.drop-area');

        const totalObjetos = objetosPorRonda.reduce((sum, ronda) => sum + ronda.length, 0);

        const botes = {
            reutilizable: document.querySelector('#reutilizables .bote-svg-button'),
            'no-reutilizable': document.querySelector('#no-reutilizables .bote-svg-button'),
        };

        function startTimer() {
            if (!hasStarted) {
                hasStarted = true;
                startTime = Date.now();
                timerInterval = setInterval(() => {
                    const elapsed = Math.floor((Date.now() - startTime) / 1000);
                    document.getElementById('timer').textContent = `Tiempo: ${elapsed}s`;
                }, 1000);
            }
        }

        function stopTimer() {
            if (timerInterval) {
                clearInterval(timerInterval);
                const elapsed = Math.floor((Date.now() - startTime) / 1000);
                document.getElementById('tiempo-final').textContent = `Tiempo: ${elapsed}s`;
                return elapsed;
            }
            return 0;
        }

        function iniciarJuego() {
            rondaActual = 0;
            errorCount = 0;
            hasStarted = false;
            contadorRondas.textContent = `Ronda ${rondaActual + 1} de ${totalRondas}`;
            mensajeFinal.style.display = 'none';
            nuevaRondaBtn.style.display = 'none';
            resultModal.classList.add('d-none');
            document.getElementById('timer').textContent = `Tiempo: 0s`;
            cargarRonda(rondaActual);
        }

        function cargarRonda(numRonda) {
            objetosContainer.innerHTML = '';
            document.querySelectorAll('.drop-area').forEach(area => {
                area.innerHTML = '';
            });

            objetosEnJuego = objetosPorRonda[numRonda];

            objetosEnJuego.forEach((obj, index) => {
                const elemento = document.createElement('div');
                elemento.className = 'objeto';
                elemento.setAttribute('draggable', 'true');
                elemento.setAttribute('data-tipo', obj.tipo);
                elemento.id = `obj-${numRonda}-${index}`;
                elemento.title = obj.nombre;
                elemento.tabIndex = 0;

                const img = document.createElement('img');
                img.src = obj.imagen;
                img.alt = obj.nombre;
                img.style.maxWidth = '80%';
                img.style.maxHeight = '80%';
                img.style.objectFit = 'contain';

                elemento.appendChild(img);
                objetosContainer.appendChild(elemento);
            });

            setTimeout(configurarEventosArrastre, 500);
        }

        function configurarEventosArrastre() {
            const objetos = document.querySelectorAll('.objeto');

            objetos.forEach(obj => {
                obj.addEventListener('dragstart', e => {
                    if (!hasStarted) {
                        startTimer();
                    }
                    e.dataTransfer.setData('text/plain', obj.id);
                    obj.classList.add('dragging');
                });

                obj.addEventListener('dragend', e => {
                    obj.classList.remove('dragging');
                    verificarFinRonda();
                });
            });

            dropAreas.forEach(area => {
                area.addEventListener('dragenter', e => {
                    e.preventDefault();
                    area.classList.add('dragover');
                });

                area.addEventListener('dragover', e => {
                    e.preventDefault();
                    area.classList.add('dragover');
                });

                area.addEventListener('dragleave', e => {
                    area.classList.remove('dragover');
                });

                area.addEventListener('drop', e => {
                    e.preventDefault();
                    area.classList.remove('dragover');

                    const id = e.dataTransfer.getData('text/plain');
                    const draggedObj = document.getElementById(id);
                    if (!draggedObj) return;

                    const container = area.closest('.bote');
                    const containerTipo = container.classList.contains('reutilizable') ? 'reutilizable' : 'no-reutilizable';
                    const tipo = draggedObj.getAttribute('data-tipo');

                    if (tipo === containerTipo) {
                        const objetoRect = draggedObj.getBoundingClientRect();
                        const botonSvg = botes[containerTipo];
                        const botonRect = botonSvg.getBoundingClientRect();

                        const clone = draggedObj.cloneNode(true);
                        clone.style.position = 'fixed';
                        clone.style.left = `${objetoRect.left}px`;
                        clone.style.top = `${objetoRect.top}px`;
                        clone.style.width = `${objetoRect.width}px`;
                        clone.style.height = `${objetoRect.height}px`;
                        clone.style.margin = '0';
                        clone.style.zIndex = '1000';
                        clone.style.transition = 'all 0.6s ease-in-out, opacity 0.4s ease';
                        document.body.appendChild(clone);

                        draggedObj.style.visibility = 'hidden';
                        clone.getBoundingClientRect();

                        const targetX = botonRect.left + botonRect.width / 2 - objetoRect.width / 2;
                        const targetY = botonRect.top + botonRect.height / 2 - objetoRect.height / 2;

                        clone.style.left = `${targetX}px`;
                        clone.style.top = `${targetY}px`;
                        clone.style.transform = 'scale(0.3) rotate(360deg)';
                        clone.style.opacity = '0';

                        clone.addEventListener('transitionend', () => {
                            clone.remove();
                            draggedObj.remove();
                            verificarFinRonda();
                        });
                    } else {
                        errorCount++;
                        const mensaje = document.getElementById('mensaje-error');
                        mensaje.style.display = 'block';
                        setTimeout(() => {
                            mensaje.style.display = 'none';
                        }, 2500);
                    }
                });
            });
        }

        function verificarFinRonda() {
            const objetosRestantes = document.querySelectorAll('.objeto:not([style*="visibility: hidden"])');

            if (objetosRestantes.length === 0) {
                if (rondaActual < totalRondas - 1) {
                    nuevaRondaBtn.style.display = 'block';
                } else {
                    const tiempoResolucion = stopTimer();
                    mensajeFinal.style.display = 'block';
                    contadorRondas.textContent = '¡Juego completado!';
                    showResultModal(tiempoResolucion);
                    registrarPartida('clasificacion', tiempoResolucion, errorCount);
                }
            }
        }

        function showResultModal(tiempo) {
            let message;
            const errorSummary = `Tuviste ${errorCount} ${errorCount === 1 ? 'error' : 'errores'} de ${totalObjetos}.`;
            if (errorCount === 0) {
                message = `${errorSummary} ¡Eres muy bueno clasificando, sigue así! ¡Bien hecho!`;
            } else if (errorCount <= 3) {
                message = `${errorSummary} Sigue practicando el reciclaje. ¡Bien hecho!`;
            } else {
                message = `${errorSummary} ¡Practica más para mejorar tu reciclaje! ¡Bien hecho!`;
            }
            modalResultMessage.textContent = message;
            resultModal.classList.remove('d-none');
        }

        function closeModal() {
            resultModal.classList.add('d-none');
            iniciarJuego();
        }

        function registrarPartida(tipo, tiempo, errores) {
            fetch(`/juegos/completar/${tipo}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ tiempo_resolucion: tiempo, errores: errores })
            })
                .then(response => response.json())
                .then(data => {
                    console.log("✅ Partida guardada:", data);
                    if (data.nuevo_logro) {
                        mostrarNuevoLogro(data.nuevo_logro);
                    }
                })
                .catch(error => console.error("❌ Error al registrar partida:", error));
        }

        function mostrarNuevoLogro(nombre) {
            const div = document.createElement("div");
            div.textContent = `🏅 ¡Nuevo logro desbloqueado: ${nombre}!`;
            div.style.position = "fixed";
            div.style.top = "10%";
            div.style.left = "50%";
            div.style.transform = "translateX(-50%)";
            div.style.padding = "1rem 2rem";
            div.style.backgroundColor = "#ffe066";
            div.style.color = "#333";
            div.style.fontSize = "1.5rem";
            div.style.fontWeight = "bold";
            div.style.borderRadius = "20px";
            div.style.boxShadow = "0 0 15px rgba(0,0,0,0.3)";
            div.style.zIndex = "10001";
            div.style.animation = "fadeOut 4s forwards";

            document.body.appendChild(div);
            setTimeout(() => div.remove(), 4000);
        }

        nuevaRondaBtn.addEventListener('click', () => {
            rondaActual++;
            contadorRondas.textContent = `Ronda ${rondaActual + 1} de ${totalRondas}`;
            nuevaRondaBtn.style.display = 'none';
            cargarRonda(rondaActual);
        });

        window.addEventListener('DOMContentLoaded', iniciarJuego);
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
