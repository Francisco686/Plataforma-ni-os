@extends('layouts.app')

@section('content')
    <style>
        :root {
            --cell-size: 50px;
            --cell-size-mobile: 40px;
            --emoji-bounce-duration: 1.5s;
            --emoji-translate-y: -10px;
            --emoji-min-delay: 20000; /* 20s in ms */
            --emoji-max-delay: 30000; /* 30s in ms */
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

        h1 {
            font-size: 4rem;
            color: #0d6efd;
            font-weight: 900;
            text-shadow: 3px 3px #d0f0ff;
            margin-bottom: 3rem;
            text-align: center;
            animation: pulse 2s infinite;
        }

        .card {
            border-radius: 2rem;
            background: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            padding: 3rem;
            width: 100%;
        }

        .card:hover {
            box-shadow: 0 12px 30px rgba(0, 123, 255, 0.3);
        }

        .card-body {
            display: flex;
            flex-direction: row;
            gap: 20px;
        }

        .card-text {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.2rem;
            text-align: center;
        }

        .btn-solid {
            color: #fff;
            font-weight: 600;
            padding: 0.9rem 2.2rem;
            border-radius: 1.2rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-green { background-color: #22c55e; }
        .btn-green:hover { background-color: #15803d; transform: translateY(-2px); }

        .btn-back {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 1000;
        }

        .section-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            width: 200px;
        }

        .reset-button {
            padding: 5px 10px;
            border-radius: 10px;
            background-color: #22c55e;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            transition: all 0.3s ease;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            text-align: center;
        }

        .reset-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
            background-color: #15803d;
        }

        .game-container {
            display: grid;
            grid-template-columns: repeat(10, var(--cell-size));
            gap: 5px;
            justify-content: center;
            max-width: 600px;
        }

        .game-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }

        .cell {
            width: var(--cell-size);
            height: var(--cell-size);
            background-color: white;
            border: 2px dashed #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #2b2b2b;
            user-select: none;
            cursor: pointer;
            font-size: 1.2rem;
        }

        .cell.bounce {
            animation: bounce var(--emoji-bounce-duration) ease-in-out 1;
        }

        .selected {
            background-color: #d3f9d8;
            border: 2px solid #4caf50;
        }

        .found {
            background-color: #6ae86a !important;
            color: white !important;
        }

        .word-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .word-list span {
            padding: 5px 10px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            transition: all 0.3s ease;
            width: 100%;
            text-align: center;
        }

        .word-list span:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.3);
        }

        .victory-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .victory-content {
            background-color: #fff;
            padding: 3rem;
            border-radius: 2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            max-width: 800px;
            width: 90%;
            text-align: center;
        }

        .victory-content h1 {
            font-size: 5rem;
            color: #22c55e;
            text-shadow: 3px 3px #d0f0ff;
        }

        #confetti {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10000;
        }

        .timer {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1rem;
            text-align: center;
            font-weight: bold;
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(var(--emoji-translate-y)); }
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 3rem;
            }

            .victory-content h1 {
                font-size: 3.5rem;
            }

            .card {
                padding: 2rem;
            }

            .card-body {
                flex-direction: column;
            }

            .card-text {
                font-size: 1.3rem;
            }

            .victory-content {
                padding: 1.5rem;
            }

            .game-container {
                grid-template-columns: repeat(10, var(--cell-size-mobile));
                gap: 4px;
            }

            .cell {
                width: var(--cell-size-mobile);
                height: var(--cell-size-mobile);
                font-size: 1rem;
            }

            .section-container {
                padding: 0 1rem;
            }

            .sidebar {
                width: 100%;
                align-items: center;
            }

            .word-list {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
            }

            .word-list span {
                width: auto;
            }

            .reset-button {
                width: auto;
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
            <a href="{{ route('juegos.index') }}" class="btn btn-solid btn-green animate__animated animate__fadeIn">
                <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
            </a>
        </div>

        <h1 class="animate__animated animate__pulse">🔍 Sopa de Letras Ecológica</h1>

        <div class="timer" id="timer">Tiempo: 0s</div>

        <section class="section-container">
            <div class="card">
                <div class="card-body">
                    <div class="sidebar">
                        <button id="reset" class="reset-button">🔄 Nueva Partida</button>
                        <div class="word-list" id="word-list"></div>
                    </div>
                    <div class="game-content">
                        <p class="card-text">Arrastra tu dedo o cursor para encontrar las palabras ocultas</p>
                        <div id="grid" class="game-container"></div>
                    </div>
                </div>
            </div>
        </section>

        <div id="ganaste" class="victory-overlay" style="display: none;">
            <div class="victory-content animate__animated animate__zoomIn">
                <h1 class="fw-bold mb-4 animate__animated animate__tada">🎉 ¡Felicidades!</h1>
                <p class="card-text">¡Encontraste todas las palabras! 🌱</p>
                <p class="card-text" id="tiempo-final">Tiempo: 0s</p>
                <button id="restart" class="btn btn-solid btn-green mt-3">🔁 Jugar Otra Partida</button>
            </div>
            <canvas id="confetti"></canvas>
        </div>
    </div>

    <audio id="victory-sound" src="{{ asset('audio/victory.mp3') }}" preload="auto"></audio>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const palabrasBase = [
                "AGUA", "RECICLA", "PLANTA", "TIERRA", "VERDE", "ECO", "SOL", "HOJA", "FLOR", "BASURA",
                "OXIGENO", "PAPEL", "CUIDAR", "REUTILIZAR", "ARBOL", "BOSQUE", "CLIMA", "ENERGIA",
                "FAUNA", "FLORA", "GLOBAL", "HIELO", "MAR", "NATURALEZA", "OZONO", "PLANETA",
                "RENOVABLE", "SOSTENIBLE", "VIENTO"
            ];

            let gridSize = 10;
            let grid = [];
            let selected = [];
            let palabras = [];
            let startTime = null;
            let timerInterval = null;
            let hasStarted = false;

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

            function crearGrid() {
                grid = Array(gridSize).fill().map(() => Array(gridSize).fill(''));
                selected = [];
                document.getElementById('grid').innerHTML = '';
                document.getElementById('ganaste').style.display = 'none';
                palabras = [...palabrasBase].sort(() => 0.5 - Math.random()).slice(0, 6);
                palabras.forEach(palabra => ponerPalabra(palabra));
                llenarRestantes();
                mostrarGrid();
                mostrarPalabras(palabras);
                hasStarted = false;
                document.getElementById('timer').textContent = `Tiempo: 0s`;
                const cells = document.querySelectorAll('.cell');
                const minDelay = 20000;
                const maxDelay = 30000;

                function triggerBounce(cell) {
                    cell.classList.add('bounce');
                    setTimeout(() => cell.classList.remove('bounce'), 1500);
                    setTimeout(() => triggerBounce(cell), Math.random() * (maxDelay - minDelay) + minDelay);
                }

                cells.forEach(cell => {
                    setTimeout(() => triggerBounce(cell), Math.random() * (maxDelay - minDelay) + minDelay);
                });
            }

            function ponerPalabra(palabra) {
                let colocado = false;
                while (!colocado) {
                    let x = Math.floor(Math.random() * gridSize);
                    let y = Math.floor(Math.random() * gridSize);
                    let horizontal = Math.random() > 0.5;

                    if (horizontal && x + palabra.length <= gridSize) {
                        if (grid[y].slice(x, x + palabra.length).every((v, i) => !v || v === palabra[i])) {
                            palabra.split('').forEach((letra, i) => grid[y][x + i] = letra);
                            colocado = true;
                        }
                    } else if (!horizontal && y + palabra.length <= gridSize) {
                        if (grid.slice(y, y + palabra.length).every((fila, i) => !fila[x] || fila[x] === palabra[i])) {
                            palabra.split('').forEach((letra, i) => grid[y + i][x] = letra);
                            colocado = true;
                        }
                    }
                }
            }

            function llenarRestantes() {
                for (let y = 0; y < gridSize; y++) {
                    for (let x = 0; x < gridSize; x++) {
                        if (!grid[y][x]) grid[y][x] = String.fromCharCode(65 + Math.floor(Math.random() * 26));
                    }
                }
            }

            function mostrarGrid() {
                const gridDiv = document.getElementById('grid');
                gridDiv.innerHTML = '';
                for (let y = 0; y < gridSize; y++) {
                    for (let x = 0; x < gridSize; x++) {
                        const cell = document.createElement('div');
                        cell.className = 'cell';
                        cell.textContent = grid[y][x];
                        cell.dataset.x = x;
                        cell.dataset.y = y;
                        cell.addEventListener('mousedown', comenzarSeleccion);
                        cell.addEventListener('mouseover', seleccionar);
                        cell.addEventListener('mouseup', terminarSeleccion);
                        gridDiv.appendChild(cell);
                    }
                }
            }

            function mostrarPalabras(lista) {
                const contenedor = document.getElementById('word-list');
                contenedor.innerHTML = '';
                lista.forEach(p => {
                    const span = document.createElement('span');
                    span.textContent = p;
                    contenedor.appendChild(span);
                });
            }

            let seleccionando = false;
            let seleccionadas = [];

            function comenzarSeleccion(e) {
                seleccionando = true;
                seleccionadas = [];
                setTimeout(() => {
                    startTimer();
                }, 1000); // Start timer after 1.5 seconds
                seleccionar(e);
            }

            function seleccionar(e) {
                if (!seleccionando) return;
                const celda = e.target;
                const coord = `${celda.dataset.x}-${celda.dataset.y}`;
                if (!seleccionadas.includes(coord)) {
                    celda.classList.add('selected');
                    seleccionadas.push(coord);
                }
            }

            function terminarSeleccion() {
                seleccionando = false;
                let palabra = seleccionadas.map(coord => {
                    const [x, y] = coord.split('-');
                    return grid[y][x];
                }).join('');
                if (palabras.includes(palabra)) {
                    seleccionadas.forEach(coord => {
                        const [x, y] = coord.split('-');
                        const celda = document.querySelector(`.cell[data-x="${x}"][data-y="${y}"]`);
                        celda.classList.remove('selected');
                        celda.classList.add('found');
                    });

                    const span = [...document.getElementById('word-list').children].find(s => s.textContent === palabra);
                    span.style.textDecoration = 'line-through';
                    span.style.color = 'green';

                    const todos = [...document.querySelectorAll('.word-list span')];
                    if (todos.every(s => s.style.textDecoration === 'line-through')) {
                        const tiempoResolucion = stopTimer();
                        document.getElementById('ganaste').style.display = 'flex';
                        const victorySound = document.getElementById('victory-sound');
                        victorySound.currentTime = 0;
                        victorySound.play().catch(e => console.log("No se pudo reproducir el audio automáticamente:", e));

                        confetti({
                            particleCount: 100,
                            spread: 70,
                            origin: { y: 0.6 },
                            colors: ['#22c55e', '#3b82f6', '#eab308']
                        });
                        setTimeout(() => {
                            confetti({
                                particleCount: 50,
                                spread: 90,
                                origin: { y: 0.8 },
                                colors: ['#22c55e', '#3b82f6', '#eab308']
                            });
                        }, 500);

                        registrarPartida('sopa', tiempoResolucion);
                    }
                } else {
                    document.querySelectorAll('.selected').forEach(c => c.classList.remove('selected'));
                }
                seleccionadas = [];
            }

            document.getElementById('reset').addEventListener('click', crearGrid);
            document.getElementById('restart').addEventListener('click', () => {
                document.getElementById('ganaste').style.display = 'none';
                crearGrid();
            });

            function registrarPartida(tipo, tiempo) {
                fetch(`/juegos/completar/${tipo}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ tiempo_resolucion: tiempo })
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

            crearGrid();
        });
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
