@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <div class="btn-back" style="position: fixed; top: 1rem; left: 1rem; z-index: 1000;">
        <a href="{{ route('juegos.index') }}" class="btn btn-success btn-md rounded-pill shadow-lg animate_animated animate_fadeInDown"
           style="font-size: 1.1rem; padding: 0.6rem 1.6rem;">
            <i class="fas fa-arrow-left me-2"></i> Regresar a Inicio
        </a>
    </div>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Juego de Clasificación con Efecto Tragar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        #mensaje-error {
            position: relative;
            margin: 20px auto;
            text-align: center;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(220, 53, 69, 0.4);
            width: 100%;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
            background-color: #f8d7da;
            color: #842029;
            font-weight: bold;
            display: none;
            animation-duration: 0.8s;
        }

        body {
            background-color: #f8f9fa;
        }
        #objetos-container {
            padding: 15px;
            background: #f1f3f5;
            border-radius: 12px;
            margin-bottom: 30px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            min-height: 110px;
        }
        .objeto {
            width: 80px;
            height: 80px;
            cursor: grab;
            border: 2px solid #ccc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.9rem;
            user-select: none;
            background: #fff;
            transition: transform 0.3s ease, opacity 0.4s ease;
            box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
            position: relative;
            z-index: 10;
        }
        .objeto.dragging {
            opacity: 0.5;
            transform: scale(1.1);
            cursor: grabbing;
        }

        .bote {
            position: relative;
            border-radius: 12px;
            background-color: #e9ecef;
            box-shadow: inset 0 5px 10px rgba(0,0,0,0.1);
            min-height: 350px;
            user-select: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
            transition: background-color 0.3s;
            cursor: pointer;
            overflow: visible;
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
            z-index: 3;
            position: relative;
            user-select: none;
        }

        .bote .mensaje {
            margin-top: 8px;
            font-weight: 600;
            color: #555;
            user-select: none;
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
            position: relative;
            z-index: 1;
        }
        .drop-area.dragover {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
        }

        /* Bote SVG y animación tapa */
        .bote-svg-button {
            position: relative;
            width: 120px;
            height: 140px;
            margin-top: 10px;
            z-index: 5;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            user-select: none;
        }
        .trash-svg {
            width: 100%;
            height: 100%;
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
            overflow: visible;
        }
        #lid-group {
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            transform-origin: 12px 18px;
        }
        /* Normal hover para la tapa */
        .bote-svg-button:hover #lid-group,
            /* Cuando tiene clase .open */
        .bote-svg-button.open #lid-group {
            transform: rotate(-28deg) translateY(2px);
        }
        .bote-svg-button:active #lid-group {
            transform: rotate(-12deg) scale(0.98);
        }
        .bote-svg-button:hover .trash-svg,
        .bote-svg-button.open .trash-svg {
            transform: scale(1.08) rotate(3deg);
        }
        .bote-svg-button:active .trash-svg {
            transform: scale(0.96) rotate(-1deg);
        }

        /* Botón nueva ronda */
        #nueva-ronda-btn {
            display: none;
            margin: 20px auto;
            padding: 10px 25px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 50px;
            background-color: #0d6efd;
            color: white;
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: all 0.3s;
        }

        #nueva-ronda-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.3);
            background-color: #0b5ed7;
        }

        /* Contador de rondas */
        #contador-rondas {
            text-align: center;
            font-size: 1.2rem;
            margin-bottom: 20px;
            font-weight: bold;
            color: #495057;
        }

        /* Mensaje final */
        #mensaje-final {
            display: none;
            text-align: center;
            font-size: 1.5rem;
            margin: 30px 0;
            padding: 20px;
            background-color: #d1e7dd;
            border-radius: 10px;
            color: #0f5132;
            border: 2px solid #badbcc;
        }

        /* Animación de caída */
        @keyframes caida {
            0% {
                transform: translateY(-100px) rotate(0deg);
                opacity: 0;
            }
            100% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
            }
        }

        .objeto.caida {
            animation: caida 0.5s ease-out forwards;
        }

        .objeto {
            width: 80px;
            height: 80px;
            cursor: grab;
            border: 2px solid #ccc;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            transition: transform 0.3s ease, opacity 0.4s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 10;
            padding: 5px;
            overflow: hidden;
        }

        .objeto img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            pointer-events: none;
        }

        .objeto.dragging {
            opacity: 0.8;
            transform: scale(1.1);
            cursor: grabbing;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
<div class="container py-4">
    <h2 class="mb-4 fw-bold animate_animated animate_fadeInDown"
        style="
        background: linear-gradient(90deg, #a8edea, #43cea2);
        color: white;
        padding: 10px 20px;
        border-radius: 12px;
        box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        font-size: 1.5rem;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        letter-spacing: 0.8px;
        text-transform: uppercase;
        font-family: 'Comic Sans MS', cursive, sans-serif;
        text-align: center;
        display: block;
        margin: 0 auto;
    ">
        🎯 ¡Clasifica los materiales en su bote correcto! 🗑♻
    </h2>
    <div id="mensaje-error" class="animate_animated animate_shakeX">
        ❌ ¡Ups! Ese objeto no va en este bote. Intenta de nuevo.
    </div>


    <div id="contador-rondas">Ronda 1 de 5</div>

    <div id="mensaje-final">
        ¡Felicidades! Has completado todas las rondas del juego.
    </div>

    <!-- Zona objetos -->
    <div id="objetos-container" aria-label="Objetos para clasificar">
        <!-- Los objetos se generarán dinámicamente -->
    </div>

    <button id="nueva-ronda-btn" class="btn">Nueva Ronda</button>

    <div class="row g-4 justify-content-center">
        <!-- Bote reutilizable -->
        <div id="reutilizables" class="bote reutilizable col-md-5" aria-label="Contenedor de objetos reutilizables">
            <h4>Reutilizables ♻️</h4>

            <div class="drop-area" aria-label="Área para objetos reutilizables"></div>

            <button class="delete-button bote-svg-button" aria-label="Bote reutilizable">
                <svg
                    class="trash-svg"
                    viewBox="0 -10 64 74"
                    xmlns="http://www.w3.org/2000/svg"
                    role="img"
                    aria-hidden="true"
                >
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

        <!-- Bote no reutilizable -->
        <div id="no-reutilizables" class="bote no-reutilizable col-md-5" aria-label="Contenedor de objetos no reutilizables">
            <h4>No reutilizables 🗑️</h4>

            <div class="drop-area" aria-label="Área para objetos no reutilizables"></div>

            <button class="delete-button bote-svg-button" aria-label="Bote no reutilizable">
                <svg
                    class="trash-svg"
                    viewBox="0 -10 64 74"
                    xmlns="http://www.w3.org/2000/svg"
                    role="img"
                    aria-hidden="true"
                >
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
</div>

<script>
    // Base de datos de objetos para cada ronda
    const objetosPorRonda = [
        [
            { nombre: "Botella", tipo: "reutilizable", imagen: "/assets/images/botella.png" },
            { nombre: "Papel sucio", tipo: "no-reutilizable", imagen: "/assets/images/papel-sucio.png" },
            { nombre: "Lata", tipo: "reutilizable", imagen: "/assets/images/lata.png" },
            { nombre: "Plástico", tipo: "no-reutilizable", imagen: "/assets/images/plastico.png" },
            { nombre: "Cartón", tipo: "reutilizable", imagen: "/assets/images/carton.png" },
            { nombre: "Ropa vieja", tipo: "no-reutilizable", imagen: "/assets/images/ropa.png" },
            { nombre: "cd", tipo: "reutilizable", imagen: "/assets/images/cd.png" },
            { nombre: "Vidrio", tipo: "reutilizable", imagen: "/assets/images/vidrio.png" },
            { nombre: "Bolsa de basura", tipo: "no-reutilizable", imagen: "/assets/images/bolsa-basura.png" }
        ],
        [
            { nombre: "Periódico", tipo: "reutilizable" , imagen: "/assets/images/periodico.jpg" },
            { nombre: "Envase de yogur", tipo: "no-reutilizable" , imagen: "/assets/images/yogur.jpg" },
            { nombre: "Jarra de vidrio", tipo: "reutilizable", imagen: "/assets/images/jarra.jpg" },
            { nombre: "Pañal usado", tipo: "no-reutilizable" , imagen: "/assets/images/pañal.jpg" },
            { nombre: "Tetra pack", tipo: "reutilizable" , imagen: "/assets/images/tetra-pack.jpg" },
            { nombre: "Cepillo de dientes", tipo: "no-reutilizable" , imagen: "/assets/images/cepillo.jpg" },
            { nombre: "Libro viejo", tipo: "reutilizable" , imagen: "/assets/images/libro.jpg" },
            { nombre: "Cascara platano", tipo: "no-reutilizable" , imagen: "/assets/images/cascara_platano.png" },
            { nombre: "Bote de aluminio", tipo: "reutilizable" , imagen: "/assets/images/bote.png" },
            { nombre: "Pila gastada", tipo: "no-reutilizable" , imagen: "/assets/images/pila.jpg" },
        ],
        [
            { nombre: "Revista", tipo: "reutilizable" , imagen: "/assets/images/revista.png" },
            { nombre: "Vaso desechable", tipo: "no-reutilizable" , imagen: "/assets/images/vaso.png" },
            { nombre: "Frascos de mermelada", tipo: "reutilizable" , imagen: "/assets/images/mermelada.png" },
            { nombre: "Colilla de cigarro", tipo: "no-reutilizable" , imagen: "/assets/images/cigarro.png" },
            { nombre: "Caja de zapatos", tipo: "reutilizable" , imagen: "/assets/images/caja.png" },
            { nombre: "Chicle", tipo: "no-reutilizable" , imagen: "/assets/images/chicle.png" },
            { nombre: "Bandeja de aluminio", tipo: "reutilizable" , imagen: "/assets/images/bandeja.png" },
            { nombre: "rastrillo", tipo: "no-reutilizable" , imagen: "/assets/images/rastrillo.png" },
            { nombre: "Bolsas de tela", tipo: "reutilizable", imagen: "/assets/images/bolsa.png" },
            { nombre: "semillas de manzana", tipo: "no-reutilizable" , imagen: "/assets/images/manzana.png" },
        ],
        [
            { nombre: "Cajas de cereal", tipo: "reutilizable" , imagen: "/assets/images/caja_c.png" },
            { nombre: "Pañuelos usados", tipo: "no-reutilizable" , imagen: "/assets/images/pañuelo.png" },
            { nombre: "Botellas de shampoo", tipo: "reutilizable" , imagen: "/assets/images/shampoo.png" },
            { nombre: "Esponja de cocina", tipo: "no-reutilizable" , imagen: "/assets/images/esponja.png" },
            { nombre: "Latas de conserva", tipo: "reutilizable" , imagen: "/assets/images/lata_c.png" },
            { nombre: "Cinta adhesiva", tipo: "no-reutilizable" , imagen: "/assets/images/cinta.png" },
            { nombre: "Botes de pintura", tipo: "reutilizable", imagen: "/assets/images/pintura.png" },
            { nombre: "Filtros de café usados", tipo: "no-reutilizable" , imagen: "/assets/images/cafe.png" },
            { nombre: "Bidones de agua", tipo: "reutilizable" , imagen: "/assets/images/garrafon.png" },
            { nombre: "Papel de aluminio usado", tipo: "no-reutilizable", imagen: "/assets/images/aluminio.png" },
        ],
        [
            { nombre: "Botes de leche", tipo: "reutilizable" , imagen: "/assets/images/leche.png" },
            { nombre: "Cepillo de pelo roto", tipo: "no-reutilizable" , imagen: "/assets/images/cepillo_roto.png" },
            { nombre: "Frascos de perfume", tipo: "reutilizable" , imagen: "/assets/images/perfume.png" },
            { nombre: "Hisopos usados", tipo: "no-reutilizable" , imagen: "/assets/images/hisopos.png" },
            { nombre: "Cajas de pizza limpias", tipo: "reutilizable" , imagen: "/assets/images/pizza.png" },
            { nombre: "Cubiertos de plástico", tipo: "no-reutilizable" , imagen: "/assets/images/cubiertos.png" },
            { nombre: "Botes de conserva", tipo: "reutilizable" , imagen: "/assets/images/botella.png" },
            { nombre: "Papel de regalo usado", tipo: "no-reutilizable" , imagen: "/assets/images/regalo.png" },
            { nombre: "Bolsas de papel", tipo: "reutilizable" , imagen: "/assets/images/bolsa_papel.png" },
            { nombre: "Cápsulas de café usadas", tipo: "no-reutilizable" , imagen: "/assets/images/capsulas.png" },
        ]
    ];

    // Variables del juego
    let rondaActual = 0;
    const totalRondas = 5;
    let objetosEnJuego = [];
    const objetosContainer = document.getElementById('objetos-container');
    const nuevaRondaBtn = document.getElementById('nueva-ronda-btn');
    const contadorRondas = document.getElementById('contador-rondas');
    const mensajeFinal = document.getElementById('mensaje-final');
    const dropAreas = document.querySelectorAll('.drop-area');

    // Para guardar el botón SVG de cada bote para el efecto "tragado"
    const botes = {
        reutilizable: document.querySelector('#reutilizables .bote-svg-button'),
        'no-reutilizable': document.querySelector('#no-reutilizables .bote-svg-button'),
    };

    // Iniciar el juego
    function iniciarJuego() {
        rondaActual = 0;
        contadorRondas.textContent = `Ronda ${rondaActual + 1} de ${totalRondas}`;
        mensajeFinal.style.display = 'none';
        nuevaRondaBtn.style.display = 'none';
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
            elemento.className = 'objeto caida';
            elemento.setAttribute('draggable', 'true');
            elemento.setAttribute('data-tipo', obj.tipo);
            elemento.id = `obj-${numRonda}-${index}`;
            elemento.tabIndex = 0;
            elemento.style.animationDelay = `${index * 0.1}s`;

            // Crear elemento de imagen
            const img = document.createElement('img');
            img.src = obj.imagen;
            img.alt = obj.nombre;
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'contain';

            elemento.appendChild(img);
            objetosContainer.appendChild(elemento);
        });

        setTimeout(configurarEventosArrastre, 500);
    }
    // Configurar eventos de arrastre para los objetos
    function configurarEventosArrastre() {
        const objetos = document.querySelectorAll('.objeto');

        objetos.forEach(obj => {
            obj.addEventListener('dragstart', e => {
                e.dataTransfer.setData('text/plain', obj.id);
                obj.classList.add('dragging');
            });

            obj.addEventListener('dragend', e => {
                obj.classList.remove('dragging');

                // Verificar si todos los objetos han sido clasificados
                verificarFinRonda();
            });
        });

        dropAreas.forEach(area => {
            // Animar tapa al entrar drag
            area.addEventListener('dragenter', e => {
                e.preventDefault();
                area.classList.add('dragover');

                // Abrir tapa del bote correspondiente
                const container = area.closest('.bote');
                if (container) {
                    const btn = container.querySelector('.bote-svg-button');
                    btn.classList.add('open');
                }
            });

            area.addEventListener('dragover', e => {
                e.preventDefault();
                area.classList.add('dragover');
            });

            // Cerrar tapa al salir drag
            area.addEventListener('dragleave', e => {
                area.classList.remove('dragover');

                const container = area.closest('.bote');
                if (container) {
                    const btn = container.querySelector('.bote-svg-button');
                    btn.classList.remove('open');
                }
            });

            area.addEventListener('drop', e => {
                e.preventDefault();
                area.classList.remove('dragover');

                const container = area.closest('.bote');
                if (container) {
                    const btn = container.querySelector('.bote-svg-button');
                    btn.classList.remove('open');
                }

                const id = e.dataTransfer.getData('text/plain');
                const draggedObj = document.getElementById(id);
                if (!draggedObj) return;

                // Verificar tipo para aceptar solo el correcto
                const tipo = draggedObj.getAttribute('data-tipo');
                const containerTipo = container.classList.contains('reutilizable') ? 'reutilizable' : 'no-reutilizable';

                if (tipo === containerTipo) {
                    // Animación efecto tragar
                    // Obtener posición del objeto y del SVG del bote
                    const objetoRect = draggedObj.getBoundingClientRect();
                    const botonSvg = botes[containerTipo];
                    const botonRect = botonSvg.getBoundingClientRect();

                    // Crear clon para animar, para no mover el original (por si queremos revertir)
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

                    // Ocultar objeto original inmediatamente
                    draggedObj.style.visibility = 'hidden';

                    // Forzar reflow para que la transición funcione
                    clone.getBoundingClientRect();

                    // Mover clon al centro del SVG (aprox)
                    const targetX = botonRect.left + botonRect.width / 2 - objetoRect.width / 2;
                    const targetY = botonRect.top + botonRect.height / 2 - objetoRect.height / 2;

                    clone.style.left = `${targetX}px`;
                    clone.style.top = `${targetY}px`;
                    clone.style.transform = 'scale(0.3) rotate(360deg)';
                    clone.style.opacity = '0';

                    // Después de animación, eliminar clon y eliminar objeto original del DOM
                    clone.addEventListener('transitionend', () => {
                        clone.remove();
                        draggedObj.remove();

                        // Verificar si todos los objetos han sido clasificados
                        verificarFinRonda();
                    });
                } else {
                    const mensaje = document.getElementById('mensaje-error');
                    mensaje.style.display = 'block';
                    mensaje.classList.add('animate_animated', 'animate_shakeX');
                    setTimeout(() => {
                        mensaje.style.display = 'none';
                        mensaje.classList.remove('animate_animated', 'animate_shakeX');
                    }, 2500);
                }
            });
        });
    }

    // Verificar si todos los objetos han sido clasificados
    function verificarFinRonda() {
        const objetosRestantes = document.querySelectorAll('.objeto:not([style*="visibility: hidden"])');

        if (objetosRestantes.length === 0) {
            // Todos los objetos han sido clasificados
            if (rondaActual < totalRondas - 1) {
                // Mostrar botón para siguiente ronda
                nuevaRondaBtn.style.display = 'block';
            } else {
                // Juego completado
                mensajeFinal.style.display = 'block';
                contadorRondas.textContent = '¡Juego completado!';
            }
        }
    }

    // Evento para el botón de nueva ronda
    nuevaRondaBtn.addEventListener('click', () => {
        rondaActual++;
        contadorRondas.textContent = `Ronda ${rondaActual + 1} de ${totalRondas}`;
        nuevaRondaBtn.style.display = 'none';
        cargarRonda(rondaActual);
    });

    // Iniciar el juego cuando se carga la página
    window.addEventListener('DOMContentLoaded', iniciarJuego);
</script>
</body>
</html>
@endsection
