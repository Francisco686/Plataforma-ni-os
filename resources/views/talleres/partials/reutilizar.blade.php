@extends('layouts.app')

@section('content')

    <style>
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
            animation: float 8s ease-in-out infinite;
        }
        .emoji1 { top: 10%; left: 8%; }
        .emoji2 { top: 20%; right: 10%; }
        .emoji3 { bottom: 15%; left: 12%; }
        .emoji4 { bottom: 8%; right: 15%; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }
        @endif

        /* --- Estilos compartidos --- */
        h1 {
            font-size: 4.5rem;
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

        .card-img {
            max-height: 450px;
            object-fit: contain;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
        }

        .card-text, li {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.2rem;
        }

        .card-subcard {
            padding: 1.8rem;
            border-radius: 1rem;
            background: #f8f9fa;
            transition: transform 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card-subcard:hover {
            transform: translateY(-5px);
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

        .btn-blue { background-color: #3b82f6; }
        .btn-blue:hover { background-color: #1e40af; transform: translateY(-2px); }

        .btn-yellow { background-color: #eab308; }
        .btn-yellow:hover { background-color: #a16207; transform: translateY(-2px); }

        .btn-back {
            position: fixed;
            top: 1.5rem;
            left: 1.5rem;
            z-index: 1000;
        }

        iframe {
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            min-height: 400px;
        }

        .gallery-img {
            max-height: 350px;
            object-fit: cover;
            border-radius: 1rem;
            transition: transform 0.3s ease;
            width: 100%;
            margin-bottom: 1.5rem;
        }

        .gallery-img:hover {
            transform: scale(1.05);
        }

        .section-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        .content-row {
            display: flex;
            flex-wrap: nowrap;
            gap: 2.5rem;
            justify-content: space-between;
            align-items: start;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 3rem;
            }

            h4 {
                font-size: 1.8rem;
            }

            .card {
                padding: 2rem;
            }

            .card-img {
                max-height: 300px;
            }

            .card-text, li {
                font-size: 1.3rem;
            }

            .btn-solid {
                font-size: 1.1rem;
                padding: 0.7rem 1.8rem;
            }

            .gallery-img {
                max-height: 250px;
            }

            iframe {
                min-height: 250px;
            }

            .section-container {
                padding: 0 1rem;
            }

            .content-row {
                flex-direction: column;
                gap: 1.5rem;
            }
        }
    </style>

    <!-- Fondo animado SOLO para alumnos -->
    @if(Auth::user()->role === 'alumno')
        <div class="background-animated">
            <div class="balloon"></div>
            <div class="balloon"></div>
            <div class="balloon"></div>
            <div class="balloon"></div>
            <div class="emoji emoji1">♻️</div>
            <div class="emoji emoji2">🧵</div>
            <div class="emoji emoji3">🗑️</div>
            <div class="emoji emoji4">🛠️</div>
        </div>
    @endif

    <div class="container-fluid py-5" style="min-height: 100vh; position: relative; z-index: 1;">
        <!-- Botón de regreso -->
        <div class="btn-back">
            <a href="{{ route('talleres.index') }}" class="btn btn-solid btn-green animate__animated animate__fadeIn">
                <i class="fas fa-arrow-left me-2"></i> Volver a Mis Talleres
            </a>
        </div>

        <!-- Título -->
        <h1 class="animate__animated animate__pulse">♻️ Taller de Reutilizar</h1>

        @if(session('success'))
            <div class="alert alert-success animate__animated animate__fadeIn text-center" style="max-width: 600px; margin: 1rem auto;">
                {{ session('success') }}
            </div>
        @endif

        @if(Auth::user()->role === 'alumno')


            <!-- Sección: Cuento -->
            <section class="section-container animate__animated animate__fadeInUp">
                <div class="card">
                    <div class="card-body">
                        <div class="row content-row">
                            <div class="col-md-6 d-flex flex-column justify-content-start">
                                <h4 class="text-success">📘 Historia: Tomás y el Tesoro del Reciclaje</h4>
                                <div class="card-text">
                                    <p>Tomás era un niño curioso que un día encontró un mapa en su jardín con un mensaje que decía: "Sigue las pistas y encuentra el tesoro que salva al planeta".</p>
                                    <p>Al llegar al parque, encontró un bote de reciclaje donde una botella le habló y le explicó que si la reciclaban, podría tener una nueva vida y no contaminar el planeta.</p>
                                    <p>Con unas botellas vacías, un cartón viejo y mucha imaginación, Tomás y sus amigos construyeron un divertido juego de bolos en lugar de tirarlos a la basura. Desde entonces, Tomás entendió que el verdadero tesoro era reutilizar, porque ayudaba a cuidar la Tierra.</p>
                                    <p class="fw-bold text-success">💡 Moraleja: Antes de tirar algo, piensa cómo podrías reutilizarlo.</p>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end align-items-start">
                                <img src="https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=1350&q=80" alt="Juguetes reutilizados" class="card-img">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección: Datos Curiosos -->
            <section class="section-container animate__animated animate__fadeInUp">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-warning">💡 Datos Curiosos sobre Reutilización</h4>
                        <div class="row content-row">
                            <div class="col-md-6">
                                <div class="card-subcard border-start border-4 border-primary">
                                    <h5 class="text-primary">♻️ Energía ahorrada</h5>
                                    <p>Reutilizar 1 kg de plástico ahorra la energía equivalente a 3 horas de televisión.</p>
                                </div>
                                <div class="card-subcard border-start border-4 border-info">
                                    <h5 class="text-info">💰 Ahorro económico</h5>
                                    <p>Una familia promedio puede ahorrar $1,000 al año reutilizando objetos.</p>
                                </div>
                                <div class="card-subcard border-start border-4 border-purple">
                                    <h5 class="text-purple">🗑️ Menos basura</h5>
                                    <p>Reutilizar objetos reduce hasta un 20% los desechos en vertederos.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-subcard border-start border-4 border-success">
                                    <h5 class="text-success">🌳 Beneficio ambiental</h5>
                                    <p>Reutilizar una camiseta vieja como trapo evita la emisión de 4 kg de CO₂.</p>
                                </div>
                                <div class="card-subcard border-start border-4 border-danger">
                                    <h5 class="text-danger">🧠 Más creatividad</h5>
                                    <p>Los niños que reutilizan desarrollan un 30% más su creatividad.</p>
                                </div>
                                <div class="card-subcard border-start border-4 border-warning">
                                    <h5 class="text-warning">🛠️ Nuevos usos</h5>
                                    <p>Una botella plástica puede convertirse en una maceta o un juguete.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección: Materiales -->
            <section class="section-container animate__animated animate__fadeInUp">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-success">📦 Materiales que Puedes Reutilizar</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="card-text">
                                    <li>♻️ Botellas plásticas</li>
                                    <li>👕 Ropa vieja o rota</li>
                                    <li>📦 Cajas de cartón</li>
                                    <li>🥫 Latas de alimentos</li>
                                    <li>📰 Papel y revistas</li>
                                    <li>🧦 Calcetines sin par</li>
                                    <li>💿 Discos compactos (CD/DVD)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección: Instrucciones -->
            <section class="section-container animate__animated animate__fadeInUp">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-info">🖌️ Instrucciones para Decorar un Objeto Reutilizado</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <ol class="card-text">
                                    <li>Elige un objeto que ya no uses (botella, lata, cartón).</li>
                                    <li>Límpialo bien y déjalo secar.</li>
                                    <li>Pinta o decóralo con papel, colores, o stickers.</li>
                                    <li>Dale un nuevo uso como lapicero, maceta o caja organizadora.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección: Galería -->
            <section class="section-container animate__animated animate__fadeInUp">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-info">🖼️ Galería de Reutilización</h4>
                        <div class="row content-row">
                            <div class="col-md-6">
                                <img src="{{ asset('assets/images/reutilizar2.png') }}" class="gallery-img img-fluid" alt="Reutilizar 2">
                                <img src="{{ asset('assets/images/reutilizar3.jpg') }}" class="gallery-img img-fluid" alt="Reutilizar 3">
                                <img src="{{ asset('assets/images/reutilizar4.jpg') }}" class="gallery-img img-fluid" alt="Botellas reutilizadas">
                            </div>
                            <div class="col-md-6">
                                <img src="{{ asset('assets/images/reutilizar5.jpg') }}" class="gallery-img img-fluid" alt="Ahorrando agua">
                                <img src="{{ asset('assets/images/reutilizar6.jpg') }}" class="gallery-img img-fluid" alt="Niño tomando agua">
                                <img src="{{ asset('assets/images/reutilizar7.jpg') }}" class="gallery-img img-fluid" alt="Latas reutilizadas">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Sección: Videos -->
            <section class="section-container animate__animated animate__fadeInUp">
                <div class="card">
                    <div class="card-body">
                        <h4 class="text-danger">🎬 Videos Educativos</h4>
                        <div class="row content-row">
                            <div class="col-md-6">
                                <div class="ratio ratio-16x9 mb-3">
                                    <iframe src="https://www.youtube.com/embed/vBoKKzX4neU" frameborder="0" allowfullscreen></iframe>
                                </div>
                                <h5 class="text-danger">Cosas que Puedes Reutilizar</h5>
                                <p class="card-text">Aprende cómo reutilizar objetos cotidianos.</p>
                            </div>
                            <div class="col-md-6">
                                <div class="ratio ratio-16x9 mb-3">
                                    <iframe src="https://www.youtube.com/embed/cvakvfXj0KE" frameborder="0" allowfullscreen></iframe>
                                </div>
                                <h5 class="text-danger">¿Qué es Reutilizar?</h5>
                                <p class="card-text">Descubre cómo mejorar el mundo con la reutilización.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .text-purple { color: #8b5cf6; }
        .border-purple { border-color: #8b5cf6; }
    </style>
@endsection
