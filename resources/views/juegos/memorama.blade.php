@extends('layouts.app')

@section('content')
<div class="btn-back" style="position: fixed; top: 1rem; left: 1rem; z-index: 1000;">
    <a href="{{ route('juegos.index') }}" class="btn btn-primary btn-md rounded-pill shadow">
        <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
    </a>
</div>

<div class="text-center my-5">
    <h2 class="fw-bold display-3 animate__animated animate__rubberBand" style="
        font-size: 4rem;
        color: #fff;
        padding: 0.5rem 1rem;
        background: linear-gradient(135deg, #06b6d4, #3b82f6);
        border-radius: 1rem;
        box-shadow: 0 0 25px rgba(0, 0, 0, 0.4);
        display: inline-block;
        text-shadow: 2px 2px 4px #000;
    ">
        Memorama Ecológico
    </h2>
    <p class="text-dark fs-5 animate__animated animate__fadeInDown animate__delay-1s mt-3" style="font-weight: 500;">
        🌍 ¡Recuerda las tarjetas ecológicas y encuentra los pares mágicos! ✨
    </p>
</div>




<div class="contenido-centro">
    <div id="game-board" class="game-container d-flex flex-wrap justify-content-center gap-4 mb-5"></div>

    <!-- Pantalla de Ganador -->
    <div id="game-result" class="victory-overlay" style="display: none;">
        <div class="victory-content text-center">
            <h1 class="text-success fw-bold mb-4 animate__animated animate__tada display-3">🎉 ¡Felicidades Campeón!</h1>
            <p class="fs-4 text-dark">Has completado el juego ecológico con éxito 🥳</p>
            <button id="restart-button" class="btn btn-success btn-lg mt-3 shadow">🔁 Jugar Otra Partida</button>
        </div>
        <canvas id="fireworks"></canvas>
        <audio id="victory-sound" src="{{ asset('audio/bienvenida.mp3') }}" preload="auto"></audio>
    </div>
</div>

<!-- Estilos -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    .contenido-centro {
        max-width: 1200px;
        padding: 2rem;
        margin: auto;
        background-color: rgba(255, 255, 255, 0.25);
        backdrop-filter: blur(10px);
        border-radius: 1rem;
    }

    .game-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1.5rem;
    }

    .game-card {
        width: 120px;
        height: 120px;
        position: relative;
        perspective: 1000px;
        cursor: pointer;
    }

    .game-card-inner {
        position: relative;
        width: 100%;
        height: 100%;
        transform-style: preserve-3d;
        transition: transform 0.6s ease-in-out;
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
    }

    .card-front {
        background-color: #fff;
        transform: rotateY(180deg);
    }

    .card-back {
        background-color: #86efac;
        font-size: 2rem;
    }

    .card-front img {
        max-width: 100%;
        max-height: 100%;
        border-radius: 10px;
    }

    .victory-overlay {
        position: fixed;
        top: 0; left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        z-index: 9999;
        text-align: center;
    }

    .victory-content {
        background-color: #fff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 0 20px rgba(0,0,0,0.2);
        z-index: 2;
    }

    #fireworks {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 1;
    }
</style>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/fireworks-js@2.10.0/dist/index.umd.js"></script>
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

    let flippedCards = [];
    let matchedPairs = 0;
    let totalPairs = 4;
    let fireworksInstance = null;

    function initGame() {
        gameBoard.innerHTML = "";
        gameResult.style.display = "none";
        flippedCards = [];
        matchedPairs = 0;

        if (fireworksInstance) fireworksInstance.stop();

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

        setTimeout(() => {
            document.querySelectorAll(".game-card").forEach(el => el.classList.add("flipped"));
            setTimeout(() => {
                document.querySelectorAll(".game-card").forEach(el => el.classList.remove("flipped"));
            }, 2000);
        }, 300);
    }

    function flipCard(cardEl) {
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
                    setTimeout(showVictory, 800);
                }
            } else {
                setTimeout(() => {
                    flippedCards.forEach(c => c.classList.remove("flipped"));
                    flippedCards = [];
                }, 1000);
            }
        }
    }

    function showVictory() {
        gameResult.style.display = "flex";
        victorySound.play();



        fireworksInstance = new Fireworks(document.getElementById("fireworks"), {
            hue: { min: 0, max: 360 },
            delay: { min: 15, max: 30 },
            rocketsPoint: 50,
            speed: 3,
            acceleration: 1.05,
            friction: 0.95,
            gravity: 1,
            particles: 100,
            trace: 3,
            explosion: 5
        });
        fireworksInstance.start();
    }

    restartButton.addEventListener("click", () => {
        gameResult.style.display = "none";
        initGame();
    });

    initGame();
});
</script>
@endsection
