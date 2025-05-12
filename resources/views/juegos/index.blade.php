@extends('layouts.app')

@section('content')
    <!-- Botón de Regresar en la esquina superior izquierda -->
    <div class="btn-back" style="position: fixed; top: 1rem; left: 1rem; z-index: 1000;">
        <a href="{{ route('home') }}" class="btn btn-primary btn-md rounded-pill shadow">
            <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
        </a>
    </div>

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
