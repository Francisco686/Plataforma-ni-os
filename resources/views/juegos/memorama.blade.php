@extends('layouts.app')

@section('content')
    <style>
        :root {
            --card-flip-duration: 0.6s;
            --emoji-bounce-duration: 1.5s;
            --emoji-translate-y: -10px;
            --emoji-min-delay: 20000;
            --emoji-max-delay: 30000;
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

        h4 {
            font-size: 2.2rem;
            font-weight: 700;
            text-shadow: 1px 1px #d0f0ff;
            margin-bottom: 1.5rem;
        }

        .card {
            border-radius: 2rem;
            background: white;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            padding: 3rem;
            width: 100%;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.02);
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

        .game-container {
            display: grid;
            grid-template-columns: repeat(4, 160px);
            grid-template-rows: repeat(2, 160px);
            gap: 2rem;
            justify-content: center;
        }

        .game-card {
            width: 160px;
            height: 160px;
            position: relative;
            perspective: 1000px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .game-card:hover {
            transform: scale(1.05);
        }

        .game-card-inner {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform var(--card-flip-duration) ease-in-out;
        }

        .game-card.flipped .game-card-inner {
            transform: rotateY(180deg);
        }

        .card-front, .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 10px;
            backface-visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px dashed #ddd;
        }

        .card-front {
            background-color: #fff;
            transform: rotateY(180deg);
        }

        .card-back {
            background-color: #86efac;
            font-size: 2.5rem;
        }

        .card-back.bounce {
            animation: bounce var(--emoji-bounce-duration) ease-in-out 1;
        }

        .card-front img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 10px;
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

        .errors {
            font-size: 1.5rem;
            color: #dc3545;
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

            h4 {
                font-size: 1.8rem;
            }

            .card {
                padding: 2rem;
            }

            .card-text {
                font-size: 1.3rem;
            }

            .btn-solid {
                font-size: 1.1rem;
                padding: 0.7rem 1.8rem;
            }

            .victory-content {
                padding: 1.5rem;
            }

            .game-container {
                grid-template-columns: repeat(2, 120px);
                grid-template-rows: repeat(4, 120px);
                gap: 1.5rem;
            }

            .game-card {
                width: 120px;
                height: 120px;
            }

            .card-back {
                font-size: 1.8rem;
            }

            .section-container {
                padding: 0 1rem;
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
        <!-- Botón de regreso -->
        <div class="btn-back">
            <a href="{{ route('juegos.index') }}" class="btn btn-solid btn-green animate__animated animate__fadeIn">
                <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
            </a>
        </div>

        <!-- Título -->
        <h1 class="animate__animated animate__pulse">🌍 Memorama Ecológico</h1>

        <!-- Temporizador y contador de errores -->
        <div class="timer" id="timer">Tiempo: 0s</div>
        <div class="errors" id="errors">Errores: 0</div>

        <!-- Sección: Tablero de Juego -->
        <section class="section-container animate__animated animate__fadeInUp">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-success">🎲 Tablero de Juego</h4>
                    <div id="game-board" class="game-container"></div>
                </div>
            </div>
        </section>

        <!-- Pantalla de Ganador -->
        <div id="game-result" class="victory-overlay" style="display: none;">
            <div class="victory-content animate__animated animate__zoomIn">
                <h1 class="fw-bold mb-4 animate__animated animate__tada">🎉 ¡Felicidades!</h1>
                <p class="card-text">Has completado el juego ecológico con éxito 🥳</p>
                <p class="card-text" id="tiempo-final">Tiempo: 0s</p>
                <p class="card-text" id="errores-final">Errores: 0</p>
                <button id="restart-button" class="btn btn-solid btn-green mt-3">🔁 Jugar Otra Partida</button>
            </div>
            <canvas id="confetti"></canvas>
        </div>
    </div>

    <!-- Audio oculto -->
    <audio id="victory-sound" src="{{ asset('audio/victory.mp3') }}" preload="auto"></audio>

    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cardsPool = [
                { id: 1, src: "{{ asset('img/agua.png') }}", alt: "Agua" },
                { id: 2, src: "{{ asset('img/reciclaje.jpg') }}", alt: "Reciclaje" },
                { id: 3, src: "{{ asset('img/energia.png') }}", alt: "Energía" },
                { id: 4, src: "{{ asset('img/arbol.png') }}", alt: "Árbol" },
                { id: 5, src: "{{ asset('img/benito.png') }}", alt: "Benito" },
                { id: 6, src: "{{ asset('img/fondo3.png') }}", alt: "Fondo" },
                { id: 7, src: "{{ asset('img/reutil1.jpeg') }}", alt: "Reutilizar" },
                { id: 8, src: "{{ asset('img/reutil3.jpeg') }}", alt: "Reutilizar 2" }
            ];

            const gameBoard = document.getElementById("game-board");
            const gameResult = document.getElementById("game-result");
            const restartButton = document.getElementById("restart-button");
            const victorySound = document.getElementById("victory-sound");
            const timerDisplay = document.getElementById("timer");
            const errorsDisplay = document.getElementById("errors");
            const tiempoFinal = document.getElementById("tiempo-final");
            const erroresFinal = document.getElementById("errores-final");

            let flippedCards = [];
            let matchedPairs = 0;
            let totalPairs = 4;
            let startTime = null;
            let timerInterval = null;
            let errorCount = 0;
            let hasStarted = false;

            function startTimer() {
                if (!hasStarted) {
                    hasStarted = true;
                    startTime = Date.now();
                    timerInterval = setInterval(() => {
                        const elapsed = Math.floor((Date.now() - startTime) / 1000);
                        timerDisplay.textContent = `Tiempo: ${elapsed}s`;
                    }, 1000);
                }
            }

            function stopTimer() {
                if (timerInterval && startTime) {
                    clearInterval(timerInterval);
                    const elapsed = Math.floor((Date.now() - startTime) / 1000);
                    timerDisplay.textContent = `Tiempo: ${elapsed}s`;
                    tiempoFinal.textContent = `Tiempo: ${elapsed}s`;
                    return elapsed > 0 ? elapsed : null; // Avoid saving 0
                }
                return null;
            }

            function updateErrors() {
                errorsDisplay.textContent = `Errores: ${errorCount}`;
                erroresFinal.textContent = `Errores: ${errorCount}`;
            }

            function initGame() {
                gameBoard.innerHTML = "";
                gameResult.style.display = "none";
                flippedCards = [];
                matchedPairs = 0;
                errorCount = 0;
                hasStarted = false;
                startTime = null;
                timerDisplay.textContent = `Tiempo: 0s`;
                updateErrors();

                let selected = cardsPool.sort(() => 0.5 - Math.random()).slice(0, totalPairs);
                let cards = [...selected, ...selected].sort(() => 0.5 - Math.random());

                cards.forEach(card => {
                    const cardEl = document.createElement("div");
                    cardEl.classList.add("game-card");
                    cardEl.innerHTML = `
                    <div class="game-card-inner" data-id="${card.id}">
                        <div class="card-back">🌱</div>
                        <div class="card-front"><img src="${card.src}" alt="${card.alt}" /></div>
                    </div>`;
                    cardEl.addEventListener("click", () => flipCard(cardEl));
                    gameBoard.appendChild(cardEl);
                });

                // Initial card preview
                setTimeout(() => {
                    document.querySelectorAll(".game-card").forEach(el => el.classList.add("flipped"));
                    setTimeout(() => {
                        document.querySelectorAll(".game-card").forEach(el => el.classList.remove("flipped"));
                    }, 1000);
                }, 300);

                // Random bounce for card-back emojis
                const cardBacks = document.querySelectorAll('.card-back');
                const minDelay = 20000;
                const maxDelay = 30000;

                function triggerBounce(cardBack) {
                    cardBack.classList.add('bounce');
                    setTimeout(() => cardBack.classList.remove('bounce'), 1500);
                    setTimeout(() => triggerBounce(cardBack), Math.random() * (maxDelay - minDelay) + minDelay);
                }

                cardBacks.forEach(cardBack => {
                    setTimeout(() => triggerBounce(cardBack), Math.random() * (maxDelay - minDelay) + minDelay);
                });
            }

            function flipCard(cardEl) {
                if (!hasStarted) {
                    startTimer();
                }

                if (flippedCards.length >= 2 || cardEl.classList.contains("flipped")) return;

                cardEl.classList.add("flipped");
                flippedCards.push(cardEl);

                if (flippedCards.length === 2) {
                    const id1 = flippedCards[0].querySelector(".game-card-inner").dataset.id;
                    const id2 = flippedCards[1].querySelector(".game-card-inner").dataset.id;

                    if (id1 === id2) {
                        flippedCards = [];
                        matchedPairs++;
                        if (matchedPairs === totalPairs) {
                            const tiempoResolucion = stopTimer();
                            if (tiempoResolucion) {
                                setTimeout(() => {
                                    showVictory(tiempoResolucion);
                                }, 800);
                            } else {
                                console.error("Tiempo de resolución inválido, no se registrará la partida.");
                            }
                        }
                    } else {
                        errorCount++;
                        updateErrors();
                        setTimeout(() => {
                            flippedCards.forEach(c => c.classList.remove("flipped"));
                            flippedCards = [];
                        }, 1000);
                    }
                }
            }

            function showVictory(tiempoResolucion) {
                gameResult.style.display = "flex";
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

                registrarPartida('memorama', tiempoResolucion, errorCount);
            }

            function registrarPartida(tipo, tiempo, errores) {
                if (!tiempo) {
                    console.error("No se puede registrar la partida: tiempo_resolucion es nulo o 0.");
                    return;
                }
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

            restartButton.addEventListener("click", () => {
                gameResult.style.display = "none";
                initGame();
            });

            initGame();
        });
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
