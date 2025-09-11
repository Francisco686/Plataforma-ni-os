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

        .cycle-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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

        .tip-img {
            max-height: 150px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
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

            .tip-img {
                max-height: 120px;
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
            <div class="emoji emoji1">💧</div>
            <div class="emoji emoji2">🌊</div>
            <div class="emoji emoji3">☁️</div>
            <div class="emoji emoji4">🌧️</div>
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
        <h1 class="animate__animated animate__pulse">💧 Aventura con el Agua</h1>

        @if(session('success'))
            <div class="alert alert-success animate__animated animate__fadeIn text-center" style="max-width: 600px; margin: 1rem auto;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Sección: Cuento -->
        <section class="section-container animate__animated animate__fadeInUp">
            <div class="card">
                <div class="card-body">
                    <div class="row content-row">
                        <div class="col-md-6 d-flex flex-column justify-content-start">
                            <h4 class="text-success">📘 Cuento: La Aventura de una Gotita</h4>
                            <div class="card-text">
                                <p>Había una vez una pequeña gota de agua llamada <strong style="color: #00BCD4;">Gota</strong> que vivía en el océano… 🌊</p>
                                <p>Un día, el sol ☀️ la calentó tanto que comenzó a evaporarse y subió al cielo. Allí se unió a otras gotitas para formar una nube blanca y esponjosa ☁️.</p>
                                <p>Cuando la nube se enfrió, Gota cayó como lluvia 🌧️ sobre una montaña 🏔️, corrió por un río 🏞️, fue bebida por un animalito 🐿️, y finalmente regresó al mar 🌊 para comenzar su viaje otra vez.</p>
                                <p class="fw-bold text-success">🌟 Moraleja: El agua nunca desaparece, solo cambia de lugar en su ciclo interminable.</p>
                            </div>
                            <div class="d-flex justify-content-around mt-3">
                                <img src="https://media.istockphoto.com/id/513906591/photo/sun.jpg?s=2048x2048&w=is&k=20&c=QT9Z51xI9UtSvX8EoPU0jZZfWIPYMZ3NAj7vNsWBPKc=" alt="Sol" class="cycle-img">
                                <img src="https://plus.unsplash.com/premium_photo-1731830999586-60b4b39b3e37?q=80&w=1243&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Nube" class="cycle-img">
                                <img src="https://plus.unsplash.com/premium_photo-1731830999625-d2999a474fee?q=80&w=1243&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Lluvia" class="cycle-img">
                                <img src="https://plus.unsplash.com/premium_photo-1744428942035-9fd6899dc334?q=80&w=1074&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Río" class="cycle-img">
                            </div>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end align-items-start">
                            <img src="https://cdn.pixabay.com/photo/2020/06/07/05/48/drop-5269146_1280.jpg" alt="Gota de agua" class="card-img">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección: Datos Curiosos -->
        <section class="section-container animate__animated animate__fadeInUp">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-warning">💡 Datos Curiosos del Agua</h4>
                    <div class="row content-row">
                        <div class="col-md-6">
                            <div class="card-subcard border-start border-4 border-primary">
                                <h5 class="text-primary">🌍 Agua en la Tierra</h5>
                                <p>El 70% de la Tierra es agua, pero solo el 3% es dulce.</p>
                            </div>
                            <div class="card-subcard border-start border-4 border-info">
                                <h5 class="text-info">🕰️ Viaje largo</h5>
                                <p>Una molécula de agua puede estar 3,000 años en el océano antes de evaporarse.</p>
                            </div>
                            <div class="card-subcard border-start border-4 border-purple">
                                <h5 class="text-purple">💧 Agua congelada</h5>
                                <p>El 68% del agua dulce está atrapada en glaciares y casquetes polares.</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-subcard border-start border-4 border-success">
                                <h5 class="text-success">👶 Cuerpo humano</h5>
                                <p>Los bebés tienen un 78% de agua en su cuerpo.</p>
                            </div>
                            <div class="card-subcard border-start border-4 border-danger">
                                <h5 class="text-danger">🍔 Agua en alimentos</h5>
                                <p>Producir una hamburguesa usa hasta 2,400 litros de agua.</p>
                            </div>
                            <div class="card-subcard border-start border-4 border-warning">
                                <h5 class="text-warning">🌱 Plantas sedientas</h5>
                                <p>Una planta de maíz necesita 650 litros de agua para crecer.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección: ¿Cómo Cuidar el Agua? -->
        <section class="section-container animate__animated animate__fadeInUp">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-success">💧 ¿Cómo cuidar el agua?</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="card-text">
                                <li>Toma duchas cortas. 🚿</li>
                                <li>Cierra el grifo mientras te cepillas los dientes. 🪥</li>
                                <li>Usa agua reciclada para regar plantas. 🌿</li>
                                <li>No tires aceite ni basura por el drenaje. 🧴</li>
                            </ul>
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
                                <iframe src="https://www.youtube.com/embed/WGe8WbOKXJg" frameborder="0" allowfullscreen></iframe>
                            </div>
                            <h5 class="text-danger">El Ciclo del Agua</h5>
                            <p class="card-text">Aprende cómo el agua viaja por nuestro planeta. 🌍</p>
                        </div>
                        <div class="col-md-6">
                            <div class="ratio ratio-16x9 mb-3">
                                <iframe src="https://www.youtube.com/embed/r3cH7KYhgq8" frameborder="0" allowfullscreen></iframe>
                            </div>
                            <h5 class="text-danger">Cómo Cuidar el Agua</h5>
                            <p class="card-text">Pequeñas acciones que hacen una gran diferencia. 💚</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .text-purple { color: #8b5cf6; }
        .border-purple { border-color: #8b5cf6; }
    </style>
@endsection
