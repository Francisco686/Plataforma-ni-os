@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #f0fdf4;
        }

        .game-card {
            background-color: #ffffff;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(0, 128, 0, 0.2);
            padding: 30px;
        }

        .form-label {
            font-size: 1.25rem;
            font-weight: bold;
            color: #2e7d32;
        }

        .preview-box {
            background-color: #e8f5e9;
            border-radius: 15px;
            padding: 10px;
        }

        select.form-select {
            font-size: 1.1rem;
        }

        h2 {
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        #preview-combo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        #preview-combo img {
            max-height: 100px;
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
        }

        .modal-overlay {
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.8), rgba(0,0,0,0.6));
            z-index: 1;
            animation: blink 2s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }

        .modal-content {
            position: relative;
            background-color: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            z-index: 2;
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.6);
            max-width: 90%;
            max-height: 90%;
        }

        .result-highlight {
            max-width: 100%;
            max-height: 400px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 20px;
            display: block;
            margin: 0 auto;
        }


    </style>

    <div class="container py-5">
        <h2 class="text-center mb-4 text-success fw-bold">🎮 Juego de Combinaciones</h2>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="game-card">
                    <form id="combine-form">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="material1" class="form-label">🧩 Material 1</label>
                                <select class="form-select" id="material1" required onchange="handleMaterialChange(1)">
                                    <option value="" selected disabled>Selecciona uno...</option>
                                    <option value="botella">Botella</option>
                                    <option value="carton">Cartón</option>
                                    <option value="ropa">Ropa</option>
                                    <option value="lata">Lata</option>
                                    <option value="cd">CD viejo</option>
                                </select>
                                <div class="text-center mt-2 preview-box">
                                    <img id="material1-img" src="" alt="Material 1" class="img-fluid">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="material2" class="form-label">🧩 Material 2</label>
                                <select class="form-select" id="material2" required onchange="handleMaterialChange(2)">
                                    <option selected disabled>Selecciona otro...</option>
                                    <option value="botella">Botella</option>
                                    <option value="carton">Cartón</option>
                                    <option value="ropa">Ropa</option>
                                    <option value="lata">Lata</option>
                                    <option value="cd">CD viejo</option>
                                </select>
                                <div class="text-center mt-2 preview-box">
                                    <img id="material2-img" src="" alt="Material 2" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <div id="preview-combo" class="text-center d-none">
                            <span class="fw-bold text-success">🔄 Combinación previa:</span>
                            <img id="material1-preview" src="" alt="Material 1">
                            <img src="/assets/images/plus.png" alt="+" style="height: 50px;">
                            <img id="material2-preview" src="" alt="Material 2">
                        </div>

                        <button type="submit" class="btn btn-success rounded-pill w-100 mt-4 fs-5">✨ Combinar Materiales</button>
                    </form>

                    <div id="result" class="mt-5 text-center d-none">
                        <h4 id="result-title" class="text-primary fw-bold"></h4>
                        <p id="result-description"></p>
                        <img id="result-image" src="" alt="Resultado" class="img-fluid mt-3" style="max-height: 250px;">
                    </div>

                    <div id="result-modal" class="modal-custom d-none">
                        <div class="modal-overlay"></div>
                        <div class="modal-content animate__animated animate__zoomIn">
                            <img id="modal-result-image" src="" class="img-fluid result-highlight">
                            <h3 id="modal-result-title" class="d-none"></h3>
                            <p id="modal-result-description" class="d-none"></p>
                            <button onclick="closeModal()" class="btn btn-danger rounded-pill mt-3">Cerrar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Botón de regresar a juegos -->
    <div class="btn-back" style="position: fixed; top: 1rem; left: 1rem; z-index: 1000;">
        <a href="{{ route('juegos.index') }}" class="btn btn-success btn-md rounded-pill shadow-lg animate_animated animate_fadeInDown"
           style="font-size: 1.1rem; padding: 0.6rem 1.6rem;">
            <i class="fas fa-arrow-left me-2"></i> Regresar a Inicio
        </a>
    </div>

    <script>
        function updateMaterialImage(num) {
            const material = materialSelects[num].value;
            const path = `/assets/images/${material}.png`;
            console.log("Asignando imagen:", path); // ← Agregado
            document.getElementById(`material${num}-img`).src = path;
        }

        const materialSelects = {
            1: document.getElementById('material1'),
            2: document.getElementById('material2')
        };

        function handleMaterialChange(num) {
            const selectedValue = materialSelects[num].value;
            const otherNum = num === 1 ? 2 : 1;
            updateMaterialImage(num);

            // Deshabilita el material seleccionado en el otro select
            Array.from(materialSelects[otherNum].options).forEach(opt => {
                opt.disabled = (opt.value === selectedValue);
            });

            // Mostrar imágenes previas si ambos están seleccionados
            const mat1 = materialSelects[1].value;
            const mat2 = materialSelects[2].value;

            if (mat1 && mat2) {
                document.getElementById('preview-combo').classList.remove('d-none');
                document.getElementById('material1-preview').src = `/assets/images/${mat1}.png`;
                document.getElementById('material2-preview').src = `/assets/images/${mat2}.png`;
            }
        }

        function updateMaterialImage(num) {
            const material = materialSelects[num].value;

            if (!material) {
                document.getElementById(`material${num}-img`).src = "";
                return;
            }

            const path = `/assets/images/${material}.png`;
            document.getElementById(`material${num}-img`).src = path;
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
                    document.getElementById('modal-result-title').textContent = data.title;
                    document.getElementById('modal-result-description').textContent = data.description;
                    document.getElementById('modal-result-image').src = data.image;
                    document.getElementById('result-modal').classList.remove('d-none');
                });
        });
    </script>
@endsection
