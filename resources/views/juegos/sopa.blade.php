<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sopa de Letras Ecológica</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: 'Comic Sans MS', cursive, sans-serif;
      background: linear-gradient(to bottom, #c8f7c5, #e0ffe0);
      margin: 0;
      padding: 20px;
      text-align: center;
    }

    h1 {
      color: #2d7a2d;
      font-size: 2.5rem;
      margin-bottom: 0.5rem;
    }

    p {
      font-size: 1.2rem;
      color: #333;
    }

    #grid {
      display: grid;
      justify-content: center;
      grid-template-columns: repeat(10, 1fr);
      gap: 5px;
      margin: 20px auto;
      max-width: 400px;
    }

    .cell {
      width: 35px;
      height: 35px;
      background-color: white;
      border: 1px solid #bbb;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      color: #2b2b2b;
      user-select: none;
      cursor: pointer;
    }

    .selected {
      background-color: #d3f9d8;
      border: 2px solid #4caf50;
    }

    .found {
      background-color: #6ae86a !important;
      color: white;
    }

    .word-list {
      margin-top: 20px;
      font-size: 1.1rem;
    }

    .word-list span {
      display: inline-block;
      margin: 5px;
      padding: 5px 10px;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 1px 1px 5px rgba(0,0,0,0.1);
    }

    #reset {
      margin-top: 30px;
      font-size: 1rem;
      padding: 10px 20px;
      border: none;
      border-radius: 20px;
      background-color: #4caf50;
      color: white;
      cursor: pointer;
    }

    #reset:hover {
      background-color: #3c9440;
    }

    .celebracion {
      display: none;
      position: fixed;
      top: 20%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 2rem;
      font-weight: bold;
      background-color: #fff3cd;
      color: #388e3c;
      padding: 20px 40px;
      border-radius: 20px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
      z-index: 9999;
      text-align: center;
      animation: zoomIn 0.6s ease;
    }

    @keyframes zoomIn {
      from { transform: scale(0.5) translate(-50%, -50%); opacity: 0; }
      to { transform: scale(1) translate(-50%, -50%); opacity: 1; }
    }

    #canvas-fuegos {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      pointer-events: none;
      z-index: 9998;
    }
  </style>
</head>
<body>
  <h1>🔍 Sopa de Letras Ecológica</h1>
  <p>Arrastra tu dedo o cursor para encontrar las palabras ocultas</p>
  <div id="grid"></div>
  <div class="word-list" id="word-list"></div>
  <button id="reset">🔄 Nueva Partida</button>

  <!-- Celebración -->
<div id="ganaste" class="celebracion text-center" style="display: none;">
    <h2 class="fw-bold display-4 text-success animate__animated animate__bounceIn">
        🎉 ¡Felicidades! ¡Encontraste todas las palabras! 🌱
    </h2>
    <canvas id="canvas-fuegos"></canvas>

    <!-- Sonido -->
    <audio id="victory-sound" src="{{ asset('audio/bienvenida.mp3') }}" preload="auto"></audio>
</div>

<!-- Fuegos artificiales JS (si usas fireworks-js o similar) -->
<script src="https://cdn.jsdelivr.net/npm/fireworks-js@2.10.0/dist/index.umd.js"></script>

<script>
    function mostrarMensajeVictoria() {
        document.getElementById('ganaste').style.display = 'block';
        // Reproducir sonido
const sonido = document.getElementById('victory-sound');
if (sonido) {
  sonido.currentTime = 0;
  sonido.play().catch(e => {
    console.log("No se pudo reproducir el audio automáticamente:", e);
  });
}


        // Reproducir música
        const sonido = document.getElementById('victory-sound');
        sonido.currentTime = 0;
        sonido.play();

        // Iniciar fuegos artificiales
        const fireworks = new Fireworks(document.getElementById('canvas-fuegos'), {
            hue: { min: 0, max: 360 },
            delay: { min: 15, max: 30 },
            speed: 2,
            acceleration: 1.05,
            friction: 0.97,
            gravity: 1.2,
            particles: 100,
            trace: 3,
            explosion: 5
        });
        fireworks.start();
    }
</script>

  <script>
    const palabrasBase = [
      "AGUA", "RECICLA", "PLANTA", "TIERRA", "VERDE", "ECO", "SOL", "HOJA", "FLOR", "BASURA", "OXIGENO", "PAPEL", "CUIDAR", "REUTILIZAR"
    ];

    let gridSize = 10;
    let grid = [];
    let selected = [];
    let palabras = [];

    function crearGrid() {
      grid = Array(gridSize).fill().map(() => Array(gridSize).fill(''));
      selected = [];
      document.getElementById('grid').innerHTML = '';
      document.getElementById('ganaste').style.display = 'none';
      document.getElementById('canvas-fuegos').getContext('2d').clearRect(0, 0, innerWidth, innerHeight);
      palabras = [...palabrasBase].sort(() => 0.5 - Math.random()).slice(0, 6);
      palabras.forEach(palabra => ponerPalabra(palabra));
      llenarRestantes();
      mostrarGrid();
      mostrarPalabras(palabras);
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
      const todos = [...document.querySelectorAll('.word-list span')];
if (todos.every(s => s.style.textDecoration === 'line-through')) {
    document.getElementById('ganaste').style.display = 'block';
    mostrarCelebracion();
    registrarPartida('sopa');
}


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
          document.getElementById('ganaste').style.display = 'block';
          mostrarCelebracion();
        }
      } else {
        document.querySelectorAll('.selected').forEach(c => c.classList.remove('selected'));
      }
      seleccionadas = [];
    }

    document.getElementById('reset').addEventListener('click', crearGrid);

    function mostrarCelebracion() {
      const canvas = document.getElementById('canvas-fuegos');
      const ctx = canvas.getContext('2d');
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;

      const fuegos = [];
      for (let i = 0; i < 60; i++) {
        fuegos.push({
          x: canvas.width / 2,
          y: canvas.height / 2,
          radius: Math.random() * 2 + 2,
          color: `hsl(${Math.random() * 360}, 100%, 60%)`,
          speedX: (Math.random() - 0.5) * 6,
          speedY: (Math.random() - 0.5) * 6,
          alpha: 1
        });
      }

      function animar() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        fuegos.forEach(p => {
          p.x += p.speedX;
          p.y += p.speedY;
          p.alpha -= 0.015;
          ctx.globalAlpha = p.alpha;
          ctx.beginPath();
          ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
          ctx.fillStyle = p.color;
          ctx.fill();
        });
        ctx.globalAlpha = 1;
        if (fuegos.some(p => p.alpha > 0)) requestAnimationFrame(animar);
      }
      animar();
    }

    crearGrid();
  </script>
  <!-- Botón flotante para regresar -->

<div class="btn-back" style="position: fixed; top: 1rem; left: 1rem; z-index: 1000;">
        <a href="{{ route('juegos.index') }}" class="btn btn-primary btn-md rounded-pill shadow">
            <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
        </a>
    </div>

<!-- Audio de victoria -->
<audio id="victory-sound" src="{{ asset('audio/bienvenida.mp3') }}" preload="auto"></audio>

<script>
function registrarPartida(tipo) {
    fetch("/jugar/" + tipo)
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
    div.style.zIndex = 9999;
    div.style.animation = "fadeOut 4s forwards";

    document.body.appendChild(div);

    setTimeout(() => div.remove(), 4000);
}
</script>



</body>





</html>

