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

        /* --- Fondo animado SOLO para alumnos --- */
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

        /* --- Estilos compartidos --- */
        h2 {
            font-size: 3.5rem;
            color: #0d6efd;
            font-weight: 900;
            text-shadow: 2px 2px #d0f0ff;
            margin-bottom: 2.5rem;
            text-align: center;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .game-card {
            background-color: #ffffff;
            border-radius: 2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            padding: 2.5rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .form-label {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2e7d32;
            margin-bottom: 0.5rem;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .form-select {
            font-size: 1rem;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            border-radius: 10px;
            padding: 0.5rem;
            border: 2px solid #ddd;
            transition: all 0.3s ease;
        }

        .form-select:focus {
            border-color: #22c55e;
            box-shadow: 0 0 8px rgba(34, 197, 94, 0.3);
        }

        .preview-box {
            background-color: #e8f5e9;
            border-radius: 15px;
            padding: 10px;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 120px;
        }

        .preview-box img {
            max-height: 100px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .preview-box img:hover {
            transform: scale(1.05);
        }

        .combination-preview {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
            margin: 20px 0;
            background-color: #f0f9ff;
            padding: 15px;
            border-radius: 15px;
            border: 2px dashed #ddd;
        }

        .combination-preview img {
            max-height: 80px;
            border-radius: 10px;
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

        .result-highlight {
            max-width: 100%;
            max-height: 300px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 15px;
            margin-bottom: 1.5rem;
        }

        .btn-solid {
            color: #fff;
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 1rem;
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

        .material-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 2.5rem;
            }

            .game-card {
                padding: 1.5rem;
            }

            .form-label {
                font-size: 1rem;
            }

            .form-select {
                font-size: 0.9rem;
            }

            .preview-box {
                min-height: 80px;
            }

            .preview-box img {
                max-height: 70px;
            }

            .combination-preview img {
                max-height: 60px;
            }

            .modal-content {
                padding: 1.5rem;
            }

            .result-highlight {
                max-height: 200px;
            }

            .btn-solid {
                font-size: 1rem;
                padding: 0.6rem 1.5rem;
            }

            .emoji {
                display: none;
            }
        }
    </style>

    <!-- Fondo animado SOLO para alumnos -->
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
                <i class="fas fa-arrow-left me-2"></i> Regresar a Inicio
            </a>
        </div>

        <!-- Título -->
        <h2>🧩 Juego de Combinaciones</h2>

        <div class="row justify-content-center">
            <div class="col-md-10 col-sm-12">
                <div class="game-card">
                    <form id="combine-form">
                        <div class="row">
                            <div class="col-md-6 mb-3 material-section">
                                <label for="material1" class="form-label">🧩 Material 1</label>
                                <select class="form-select" id="material1" required onchange="handleMaterialChange(1)">
                                    <option value="" selected disabled>Selecciona uno...</option>
                                    <option value="botella">Botella</option>
                                    <option value="carton">Cartón</option>
                                    <option value="ropa">Ropa</option>
                                    <option value="lata">Lata</option>
                                    <option value="cd">CD viejo</option>
                                </select>
                                <div class="preview-box">
                                    <img id="material1-img" src="" alt="Material 1" class="img-fluid">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 material-section">
                                <label for="material2" class="form-label">🧩 Material 2</label>
                                <select class="form-select" id="material2" required onchange="handleMaterialChange(2)">
                                    <option value="" selected disabled>Selecciona otro...</option>
                                    <option value="botella">Botella</option>
                                    <option value="carton">Cartón</option>
                                    <option value="ropa">Ropa</option>
                                    <option value="lata">Lata</option>
                                    <option value="cd">CD viejo</option>
                                </select>
                                <div class="preview-box">
                                    <img id="material2-img" src="" alt="Material 2" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="combination-preview text-center d-none" id="preview-combo">
                            <span class="fw-bold text-success">🔄 Combinación previa:</span>
                            <img id="material1-preview" src="" alt="Material 1">
                            <img src="/assets/images/plus.png" alt="+" style="height: 40px;">
                            <img id="material2-preview" src="" alt="Material 2">
                        </div>

                        <button type="submit" class="btn btn-solid btn-green w-100 mt-3 fs-5">✨ Combinar Materiales</button>
                    </form>

                    <div id="result-modal" class="modal-custom d-none">
                        <div class="modal-overlay"></div>
                        <div class="modal-content">
                            <img id="modal-result-image" src="" class="img-fluid result-highlight">
                            <h3 id="modal-result-title" class="text-primary fw-bold"></h3>
                            <p id="modal-result-description"></p>
                            <button onclick="closeModal()" class="btn btn-solid btn-dark mt-3">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const materialSelects = {
            1: document.getElementById('material1'),
            2: document.getElementById('material2')
        };

        function updateMaterialImage(num) {
            const material = materialSelects[num].value;
            const img = document.getElementById(`material${num}-img`);
            if (!material) {
                img.src = "";
                return;
            }
            const path = `/assets/images/${material}.png`;
            console.log("Asignando imagen:", path);
            img.src = path;
        }

        function handleMaterialChange(num) {
            const selectedValue = materialSelects[num].value;
            const otherNum = num === 1 ? 2 : 1;
            updateMaterialImage(num);

            // Deshabilita el material seleccionado en el otro select
            Array.from(materialSelects[otherNum].options).forEach(opt => {
                opt.disabled = (opt.value === selectedValue && opt.value !== "");
            });

            // Mostrar imágenes previas si ambos están seleccionados
            const mat1 = materialSelects[1].value;
            const mat2 = materialSelects[2].value;

            if (mat1 && mat2) {
                const previewCombo = document.getElementById('preview-combo');
                previewCombo.classList.remove('d-none');
                document.getElementById('material1-preview').src = `/assets/images/${mat1}.png`;
                document.getElementById('material2-preview').src = `/assets/images/${mat2}.png`;
            }
        }

        function closeModal() {
            document.getElementById('result-modal').classList.add('d-none');
        }

        document.getElementById('combine-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const material1 = materialSelects[1].value;
            const material2 = materialSelects[2].value;

            if (material1 === material2) {
                alert("Selecciona materiales diferentes.");
                return;
            }

            fetch('{{ url("/juegos/combinar") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    materials: [material1, material2]
                })
            })
                .then(res => res.json())
                .then(data => {
                    const modal = document.getElementById('result-modal');
                    document.getElementById('modal-result-title').textContent = data.title;
                    document.getElementById('modal-result-description').textContent = data.description;
                    document.getElementById('modal-result-image').src = data.image;
                    modal.classList.remove('d-none');
                })
                .catch(error => {
                    console.error("Error al combinar materiales:", error);
                    alert("Ocurrió un error al combinar los materiales. Intenta de nuevo.");
                });
        });
    </script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
