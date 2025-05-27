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
        body {
            background-color: #f8f9fa;
        }
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
        #objetos-container {
            padding: 15px;
            background: #f1f3f5;
            border-radius: 12px;
            margin-bottom: 15px;
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
        }
        .bote .mensaje {
            margin-top: 8px;
            font-weight: 600;
            color: #555;
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
            width: 120px;
            height: 140px;
            margin-top: 10px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
        }
        .trash-svg {
            width: 100%;
            height: 100%;
            transition: transform 0.3s;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
        }
        #lid-group {
            transition: transform 0.3s;
            transform-origin: 12px 18px;
        }
        .bote-svg-button:hover #lid-group,
        .bote-svg-button.open #lid-group {
            transform: rotate(-28deg) translateY(2px);
        }
        .bote-svg-button:hover .trash-svg,
        .bote-svg-button.open .trash-svg {
            transform: scale(1.08) rotate(3deg);
        }
        .objeto img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="text-center">
        <h2 class="mb-4 fw-bold animate__animated animate__fadeInDown"
            style="background-color: #e3f2fd; color: #0d6efd; padding: 12px 24px; border-radius: 12px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); display: inline-block;">
            Clasifica los materiales en el bote correcto
        </h2>
    </div>

    <div id="objetos-container">
        @foreach ([
            ['id' => 'obj1', 'tipo' => 'reutilizable', 'img' => 'botella.png'],
            ['id' => 'obj2', 'tipo' => 'reutilizable', 'img' => 'cd.png'],
            ['id' => 'obj3', 'tipo' => 'no-reutilizable', 'img' => 'papel-sucio.png'],
            ['id' => 'obj4', 'tipo' => 'reutilizable', 'img' => 'lata.png'],
            ['id' => 'obj5', 'tipo' => 'no-reutilizable', 'img' => 'plastico.png'],
            ['id' => 'obj6', 'tipo' => 'reutilizable', 'img' => 'carton.png'],
            ['id' => 'obj7', 'tipo' => 'no-reutilizable', 'img' => 'ropa.png'],
            ['id' => 'obj8', 'tipo' => 'no-reutilizable', 'img' => 'cascara_platano.png'],
            ['id' => 'obj9', 'tipo' => 'reutilizable', 'img' => 'vidrio.png'],
            ['id' => 'obj10', 'tipo' => 'no-reutilizable', 'img' => 'bolsa-basura.png'],
        ] as $obj)
            <div class="objeto" draggable="true" data-tipo="{{ $obj['tipo'] }}" id="{{ $obj['id'] }}">
                <img src="/assets/images/{{ $obj['img'] }}" alt="" class="w-100 h-100 object-fit-contain">
            </div>
        @endforeach
    </div>

    <div id="mensaje-error" class="animate__animated animate__shakeX">
        ❌ ¡Ups! Ese objeto no va en este bote. Intenta de nuevo.
    </div>

    <div class="row g-4 justify-content-center">
        @foreach ([
            ['id' => 'reutilizables', 'tipo' => 'reutilizable', 'color' => '#198754', 'bg' => '#d1e7dd', 'label' => 'Reutilizables ♻️'],
            ['id' => 'no-reutilizables', 'tipo' => 'no-reutilizable', 'color' => '#dc3545', 'bg' => '#f8d7da', 'label' => 'No reutilizables 🗑️']
        ] as $bote)
            <div id="{{ $bote['id'] }}" class="bote {{ $bote['tipo'] }} col-md-5">
                <h4>{{ $bote['label'] }}</h4>
                <div class="drop-area"></div>
                <button class="delete-button bote-svg-button">
                    <svg class="trash-svg" viewBox="0 -10 64 74" xmlns="http://www.w3.org/2000/svg">
                        <g id="trash-can">
                            <rect x="16" y="24" width="32" height="30" rx="3" ry="3" fill="{{ $bote['color'] }}"></rect>
                            <g id="lid-group">
                                <rect x="12" y="12" width="40" height="6" rx="2" ry="2" fill="{{ $bote['color'] }}"></rect>
                                <rect x="26" y="8" width="12" height="4" rx="2" ry="2" fill="{{ $bote['color'] }}"></rect>
                            </g>
                        </g>
                    </svg>
                </button>
                <div class="mensaje">Arrastra aquí los objetos {{ strtolower($bote['label']) }}</div>
            </div>
        @endforeach
    </div>
</div>

<script>
    const objetos = document.querySelectorAll('.objeto');
    const dropAreas = document.querySelectorAll('.drop-area');
    const botes = {
        reutilizable: document.querySelector('#reutilizables .bote-svg-button'),
        'no-reutilizable': document.querySelector('#no-reutilizables .bote-svg-button'),
    };
    objetos.forEach(obj => {
        obj.addEventListener('dragstart', e => {
            e.dataTransfer.setData('text/plain', obj.id);
            obj.classList.add('dragging');
        });
        obj.addEventListener('dragend', () => obj.classList.remove('dragging'));
    });
    dropAreas.forEach(area => {
        area.addEventListener('dragenter', e => {
            e.preventDefault();
            area.classList.add('dragover');
            const btn = area.closest('.bote').querySelector('.bote-svg-button');
            btn.classList.add('open');
        });
        area.addEventListener('dragover', e => e.preventDefault());
        area.addEventListener('dragleave', e => {
            area.classList.remove('dragover');
            const btn = area.closest('.bote').querySelector('.bote-svg-button');
            btn.classList.remove('open');
        });
        area.addEventListener('drop', e => {
            e.preventDefault();
            area.classList.remove('dragover');
            const container = area.closest('.bote');
            const btn = container.querySelector('.bote-svg-button');
            btn.classList.remove('open');
            const id = e.dataTransfer.getData('text/plain');
            const draggedObj = document.getElementById(id);
            if (!draggedObj) return;
            const tipo = draggedObj.getAttribute('data-tipo');
            const containerTipo = container.classList.contains('reutilizable') ? 'reutilizable' : 'no-reutilizable';
            if (tipo === containerTipo) {
                const objetoRect = draggedObj.getBoundingClientRect();
                const botonRect = botes[containerTipo].getBoundingClientRect();
                const clone = draggedObj.cloneNode(true);
                Object.assign(clone.style, {
                    position: 'fixed', left: `${objetoRect.left}px`, top: `${objetoRect.top}px`,
                    width: `${objetoRect.width}px`, height: `${objetoRect.height}px`,
                    margin: '0', zIndex: 1000,
                    transition: 'all 0.6s ease-in-out, opacity 0.4s ease'
                });
                document.body.appendChild(clone);
                draggedObj.style.visibility = 'hidden';
                clone.getBoundingClientRect();
                clone.style.left = `${botonRect.left + botonRect.width / 2 - objetoRect.width / 2}px`;
                clone.style.top = `${botonRect.top + botonRect.height / 2 - objetoRect.height / 2}px`;
                clone.style.transform = 'scale(0.3) rotate(360deg)';
                clone.style.opacity = '0';
                clone.addEventListener('transitionend', () => {
                    clone.remove();
                    draggedObj.remove();
                });
            } else {
                const mensaje = document.getElementById('mensaje-error');
                mensaje.style.display = 'block';
                mensaje.classList.add('animate__animated', 'animate__shakeX');
                setTimeout(() => {
                    mensaje.style.display = 'none';
                    mensaje.classList.remove('animate__animated', 'animate__shakeX');
                }, 2500);
            }
        });
    });
</script>
</body>
</html>
@endsection


