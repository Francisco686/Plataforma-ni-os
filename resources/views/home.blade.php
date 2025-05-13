@extends('layouts.customHome')

@section('content')
    <div class="container-fluid p-0 home-background" style="background-size: cover; background-position: center; min-height: 100vh; margin: 0; padding: 0;">
        <div class="row no-gutters" style="min-height: 100vh; margin: 0;">
            <div class="col-12 d-flex align-items-center justify-content-center">
                <div class="w-100 px-3 px-md-5 contenido-principal">
                    <div class="text-center welcome-message" style="margin-top: 60px;">
                        <div class="animate__animated animate__fadeInDown">
                            <h1 class="text-white font-weight-bold mb-3"><strong>¡Bienvenid@, {{ Auth::user()->name }}!</strong></h1>

                            @if(Auth::user()->role === 'alumno' && Auth::user()->grupo)
                                <div class="alert alert-info text-center mb-4">
                                    Tu grupo es: <strong>{{ Auth::user()->grupo->grado }}°{{ strtoupper(Auth::user()->grupo->grupo) }}</strong>
                                </div>
                            @endif

                            <p class="lead text-white mb-5"><strong>Explora tu plataforma de aprendizaje interactiva.</strong></p>
                        </div>

                        <!-- Contenido según rol -->
                        @if(Auth::user()->role === 'administrador')
                            <div class="row g-4 mt-4">
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <div class="card card-hover bg-success text-white text-center p-4 h-100">
                                        <i class="fas fa-tools fa-3x mb-2 icon-animate"></i>
                                        <h4>Gestión de Talleres</h4>
                                        <p>Administra todos los talleres disponibles.</p>
                                        <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm mt-auto">Administrar</a>
                                    </div>
                                </div>
                            </div>
                        @elseif(Auth::user()->isDocente())
                            <div class="row g-4 mt-4">
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="card border-0 shadow-sm h-100 bg-info text-white">
                                        <div class="card-body p-4 d-flex flex-column">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-tools fa-3x me-3"></i>
                                                <h5 class="card-title mb-0">Talleres</h5>
                                            </div>
                                            <p class="card-text flex-grow-1">Crea y asigna talleres educativos a tus alumnos.</p>
                                            <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm align-self-start mt-2">
                                                Administrar <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="card border-0 shadow-sm h-100 bg-warning text-white">
                                        <div class="card-body p-4 d-flex flex-column">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-clipboard-list fa-3x me-3"></i>
                                                <h5 class="card-title mb-0">Evaluaciones</h5>
                                            </div>
                                            <p class="card-text flex-grow-1">Monitorea el progreso de tus estudiantes.</p>
                                            <a href="{{ route('evaluaciones.index') }}" class="btn btn-light btn-sm align-self-start mt-2">
                                                Ver <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="card border-0 shadow-sm h-100 bg-danger text-white">
                                        <div class="card-body p-4 d-flex flex-column">
                                            <div class="d-flex align-items-center mb-3">
                                                <i class="fas fa-user-plus fa-3x me-3"></i>
                                                <h5 class="card-title mb-0">Alumnos</h5>
                                            </div>
                                            <p class="card-text flex-grow-1">Gestiona el registro y grupos de alumnos.</p>
                                            <a href="{{ route('alumnos.index') }}" class="btn btn-light btn-sm align-self-start mt-2">
                                                Administrar <i class="fas fa-arrow-right ms-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif(Auth::user()->role === 'alumno')
                            <!-- Pestañas para alumnos -->
                            <ul class="nav nav-tabs mb-4" id="alumnoTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="inicio-tab" data-bs-toggle="tab" href="#tab-inicio" role="tab">Inicio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="agua-tab" data-bs-toggle="tab" href="#tab-agua" role="tab">Agua</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="reciclaje-tab" data-bs-toggle="tab" href="#tab-reciclaje" role="tab">Reciclaje</a>
                                </li>
                            </ul>

                            <div class="tab-content" id="alumnoTabContent">
                                <!-- Pestaña Inicio -->
                                <div class="tab-pane fade show active" id="tab-inicio" role="tabpanel">
                                    <div class="row g-4 mt-4">
                                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                                            <div class="card card-hover bg-success text-white text-center p-4 h-100">
                                                <i class="fas fa-book fa-3x mb-2 icon-animate book-animate"></i>
                                                <h4>Mis Talleres</h4>
                                                <p>Accede a tus talleres y consulta tu progreso.</p>
                                                <a href="{{ route('talleres.index') }}" class="btn btn-light btn-sm mt-auto">Ir</a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                                            <div class="card card-hover bg-info text-white text-center p-4 h-100">
                                                <i class="fas fa-gamepad fa-3x mb-2 icon-animate gamepad-animate"></i>
                                                <h4>Zona de Juegos</h4>
                                                <p>Aprende mientras te diviertes con juegos educativos.</p>
                                                <a href="{{ route('juegos.index') }}" class="btn btn-light btn-sm mt-auto">Ir</a>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 mb-4">
                                            <div class="card card-hover bg-primary text-white text-center p-4 h-100">
                                                <i class="fas fa-star fa-3x mb-2 icon-animate star-animate"></i>
                                                <h4>Mis Logros</h4>
                                                <p>Descubre tus insignias y premios obtenidos.</p>
                                                <a href="#" class="btn btn-light btn-sm mt-auto">Ver</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pestaña Agua -->
                                <div class="tab-pane fade" id="tab-agua" role="tabpanel">
                                    <!-- Sección Bienvenida -->
                                    <section id="seccion-bienvenida" class="scroll-margin-top py-4" style="scroll-margin-top: 100px;">
                                        <div class="text-center">
                                            <h3 class="text-white mb-4">¡Aprendamos sobre el Agua!</h3>

                                        </div>
                                    </section>

                                    <!-- Contenido principal con anclas -->
                                    <div class="animate__animated animate__fadeIn">
                                        <!-- Sección Cuento -->
                                        <section id="seccion-cuento" class="row mb-4 scroll-margin-top" style="scroll-margin-top: 100px;">
                                            <div class="col-12">
                                                <div class="card bg-white text-dark p-4 shadow">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <i class="fas fa-book-open fa-2x me-3 text-primary"></i>
                                                        <h4 class="mb-0 fw-bold">Cuento: La Aventura de una Gotita</h4>
                                                    </div>
                                                    <div class="px-4">
                                                        <p class="lead">Había una vez una pequeña gota de agua llamada Gota que vivía en el océano...</p>
                                                        <p>Un día, el sol la calentó tanto que comenzó a evaporarse y subió al cielo. Allí se unió a otras gotitas para formar una nube blanca y esponjosa.</p>
                                                        <p>Cuando la nube se enfrió, Gota cayó como lluvia sobre una montaña, corrió por un río, fue bebida por un animalito, y finalmente regresó al mar para comenzar su viaje otra vez.</p>
                                                        <p class="fw-bold text-primary">Moraleja: El agua nunca desaparece, solo cambia de lugar en su ciclo interminable.</p>
                                                        <div class="text-center mt-3">
                                                            <img src="https://cdn.pixabay.com/photo/2020/06/07/05/48/drop-5269146_1280.jpg"
                                                                 alt="Gotas en hoja"
                                                                 class="img-fluid rounded"
                                                                 style="max-height: 200px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                        <!-- Sección Datos Curiosos -->
                                        <section id="seccion-datos" class="row mb-5 scroll-margin-top" style="scroll-margin-top: 100px;">
                                            <div class="col-12">
                                                <div class="card bg-white text-dark p-4 shadow">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <i class="fas fa-lightbulb fa-2x me-3 text-warning"></i>
                                                        <h4 class="mb-0 fw-bold">Datos Curiosos del Agua</h4>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="p-3 bg-light rounded mb-3 border-start border-4 border-warning">
                                                                <h5 class="fw-bold text-warning">💧 ¿Sabías que...?</h5>
                                                                <p>El 70% de la Tierra es agua, pero solo el 3% es dulce y útil para nosotros.</p>
                                                            </div>
                                                            <div class="p-3 bg-light rounded mb-3 border-start border-4 border-info">
                                                                <h5 class="fw-bold text-info">⏳ Una gota viajera</h5>
                                                                <p>Una molécula de agua puede pasar hasta 3,000 años en el océano antes de evaporarse.</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="p-3 bg-light rounded mb-3 border-start border-4 border-success">
                                                                <h5 class="fw-bold text-success">👶 Agua en tu cuerpo</h5>
                                                                <p>Los bebés tienen un 78% de agua en su cuerpo, ¡casi como un melón!</p>
                                                            </div>
                                                            <div class="p-3 bg-light rounded mb-3 border-start border-4 border-danger">
                                                                <h5 class="fw-bold text-danger">🌍 Agua escondida</h5>
                                                                <p>Producir 1 manzana necesita 70 litros de agua, y 1 hamburguesa ¡2,400 litros!</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                        <!-- Sección Cuidado del Agua -->
                                        <section id="seccion-cuidado" class="row mb-4 scroll-margin-top" style="scroll-margin-top: 100px;">
                                            <div class="col-12 col-lg-6 mb-4 mb-lg-0">
                                                <div class="card bg-white text-dark p-4 h-100 shadow">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <i class="fas fa-hands-helping fa-2x me-3 text-success"></i>
                                                        <h4 class="mb-0 fw-bold">Cómo cuidar el agua</h4>
                                                    </div>
                                                    <div class="px-2">
                                                        <div class="d-flex mb-3">
                                                            <div class="me-3 text-success">
                                                                <i class="fas fa-faucet fa-2x"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="fw-bold">Cierra el grifo</h5>
                                                                <p>Al lavarte los dientes o manos, cierra el agua mientras no la usas.</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex mb-3">
                                                            <div class="me-3 text-success">
                                                                <i class="fas fa-shower fa-2x"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="fw-bold">Baños cortos</h5>
                                                                <p>Reduce tu tiempo en la ducha. ¡5 minutos son suficientes!</p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="me-3 text-success">
                                                                <i class="fas fa-recycle fa-2x"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="fw-bold">Reutiliza</h5>
                                                                <p>Usa el agua de lavar frutas para regar plantas.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sección Galería -->
                                            <div class="col-12 col-lg-6">
                                                <div class="card bg-white p-4 h-100 shadow" id="seccion-galeria">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <i class="fas fa-images fa-2x me-3 text-info"></i>
                                                        <h4 class="mb-0 fw-bold">Galería del Agua</h4>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <img src="https://media.istockphoto.com/id/1340716614/photo/abstract-icon-representing-the-ecological-call-to-recycle-and-reuse-in-the-form-of-a-pond.jpg?s=2048x2048&w=is&k=20&c=LhJtcbr2BQ-6N-mSeeI6wlQSpOCfk0jDZGCqqZMqzXs="
                                                                 alt="Ciclo del agua"
                                                                 class="img-fluid rounded mb-2 hover-zoom"
                                                                 data-bs-toggle="tooltip"
                                                                 title="Así viaja el agua en la naturaleza">
                                                        </div>
                                                        <div class="col-6">
                                                            <img src="https://images.unsplash.com/photo-1531533748270-34089046fb49?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                                                 alt="Gotas de agua"
                                                                 class="img-fluid rounded mb-2 hover-zoom"
                                                                 data-bs-toggle="tooltip"
                                                                 title="Cada gota es importante">
                                                        </div>
                                                        <div class="col-6">
                                                            <img src="https://images.unsplash.com/photo-1495727034151-8fdc73e332a8"
                                                                 alt="Niño tomando agua"
                                                                 class="img-fluid rounded hover-zoom"
                                                                 data-bs-toggle="tooltip"
                                                                 title="El agua nos da vida">
                                                        </div>
                                                        <div class="col-6">
                                                            <img src="https://media.istockphoto.com/id/671568704/es/foto/claro-agua-natural-en-manos-de-la-mujer.jpg?s=612x612&w=0&k=20&c=-SX3JB13GipGGkMivw1AtAInvJ0TLuIEy7zm8tk_hwo="
                                                                 alt="Ahorrando agua"
                                                                 class="img-fluid rounded hover-zoom"
                                                                 data-bs-toggle="tooltip"
                                                                 title="Todos podemos ayudar">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                        <!-- Sección Videos -->
                                        <section id="seccion-videos" class="row scroll-margin-top mb-5" style="scroll-margin-top: 100px;">
                                            <div class="col-12">
                                                <div class="card bg-white p-4 shadow">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <i class="fas fa-film fa-2x me-3 text-danger"></i>
                                                        <h4 class="mb-0 fw-bold">Videos Educativos</h4>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-4 mb-md-0">
                                                            <div class="card h-100 border-0">
                                                                <div class="ratio ratio-16x9">
                                                                    <iframe src="https://www.youtube.com/embed/WGe8WbOKXJg" frameborder="0" allowfullscreen></iframe>                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title fw-bold">El Ciclo del Agua</h5>
                                                                    <p class="card-text">Aprende cómo el agua viaja por nuestro planeta.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card h-100 border-0">
                                                                <div class="ratio ratio-16x9">
                                                                    <iframe src="https://www.youtube.com/embed/TOD_9kWu3bA" frameborder="0" allowfullscreen></iframe>                                                                </div>
                                                                <div class="card-body">
                                                                    <h5 class="card-title fw-bold">Cómo Cuidar el Agua</h5>
                                                                    <p class="card-text">Pequeñas acciones que hacen una gran diferencia.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>

                                    <!-- Botón flotante para volver arriba -->
                                    <button onclick="topFunction()" id="btnTop" class="btn btn-primary rounded-circle shadow-lg"
                                            style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; display: none; border: none;">
                                        <i class="fas fa-arrow-up fa-lg"></i>
                                    </button>
                                </div>

                                <!-- Pestaña Reciclaje -->
                                <div class="tab-pane fade" id="tab-reciclaje" role="tabpanel">
                                    <div class="animate__animated animate__fadeIn">
                                        <h3 class="text-white text-center mb-4">Reciclaje</h3>
                                        <div class="card bg-white text-dark p-4">
                                            <p>¡Pronto tendrás información sobre reciclaje aquí!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-5 animate__animated animate__fadeInUp">
                            <a href="{{ route('logout') }}" class="btn btn-dark btn-lg btn-hover"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt icon-animate"></i> Cerrar Sesión
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dependencias -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Estilos generales */
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
        .btn-hover:hover {
            transform: scale(1.05);
        }
        .home-background {
            animation: subtleBackground 15s infinite alternate;
        }
        @keyframes subtleBackground {
            0% { background-position: center; }
            100% { background-position: 20% center; }
        }
        .card {
            padding: 25px 15px !important;
        }
        .card h4 {
            margin-bottom: 15px;
        }
        .card p {
            margin-bottom: 20px;
        }
        .icon-animate {
            transition: all 0.5s ease;
        }
        .book-animate {
            animation: bookFlip 3s infinite ease-in-out;
        }
        .pencil-animate {
            animation: pencilWrite 2s infinite alternate;
        }
        .gamepad-animate {
            animation: gamepadVibrate 1.5s infinite;
        }
        .star-animate {
            animation: starPulse 2s infinite alternate;
        }
        .logout-animate {
            animation: rotateLogout 4s infinite linear;
        }
        @keyframes bookFlip {
            0%, 100% { transform: rotateY(0deg); }
            50% { transform: rotateY(20deg); }
        }
        @keyframes pencilWrite {
            0% { transform: rotate(0deg) translateX(0); }
            100% { transform: rotate(5deg) translateX(5px); }
        }
        @keyframes gamepadVibrate {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px) rotate(-5deg); }
            75% { transform: translateX(3px) rotate(5deg); }
        }
        @keyframes starPulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.2); opacity: 1; text-shadow: 0 0 10px gold; }
        }
        @keyframes rotateLogout {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Estilos de pestañas */
        .nav-tabs {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: #fff;
            border-bottom: 2px solid #dee2e6;
            justify-content: center;
            margin-bottom: 20px;
        }
        .nav-tabs .nav-link {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-bottom: none;
            border-radius: 0.5rem 0.5rem 0 0;
            margin-right: 0.5rem;
            padding: 0.75rem 1.5rem;
            color: #495057;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .nav-tabs .nav-link:hover {
            background-color: #e9ecef;
        }
        .nav-tabs .nav-link.active {
            background-color: #fff;
            border-top: 3px solid #007bff;
            border-bottom: 2px solid #fff;
            color: #007bff;
        }
        .tab-content {
            background-color: transparent;
            padding: 1rem;
        }

        /* Animación del contenedor */
        .contenido-centro {
            transition: all 0.5s ease;
            max-width: 950px;
            min-height: 80vh;
            margin: 0 auto;
            padding: 2rem;
        }
        .contenido-centro.tab-agua {
            max-width: 1200px;
            min-height: 10vh;
        }

        /* Estilos para la navegación interna */
        .scroll-margin-top {
            scroll-margin-top: 120px;
        }

        /* Estilo para enlaces activos */
        .navbar-nav .nav-link.active {
            font-weight: bold;
            background-color: rgba(255,255,255,0.2);
            border-radius: 5px;
        }

        /* Efecto smooth al desplazarse */
        html {
            scroll-behavior: smooth;
        }

        /* Efecto hover para imágenes */
        .hover-zoom {
            transition: transform 0.3s ease;
        }
        .hover-zoom:hover {
            transform: scale(1.03);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Estilo para las tarjetas */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }

        /* Botón flotante */
        #btnTop {
            transition: all 0.3s ease;
        }
        #btnTop:hover {
            transform: translateY(-3px);
            background-color: #0b5ed7 !important;
        }

        /* Estilos para el margen del mensaje de bienvenida */
        .welcome-message {
            margin-top: 60px; /* Default para el mensaje principal */
        }

        /* Asegurar que la pestaña Inicio tenga el margen correcto */
        #tab-inicio .welcome-message {
            margin-top: 60px;
        }

        /* Aplicar margin-top: 1000px solo en la pestaña Agua */
        .tab-agua-active {
            margin-top: 1665px;
        }

        /* Responsividad */
        @media (max-width: 576px) {
            .contenido-centro {
                max-width: 95% !important;
                padding: 1rem !important;
            }
            .contenido-centro.tab-agua {
                max-width: 95% !important;
                min-height: 100vh;
            }
            .nav-tabs {
                flex-direction: column;
            }
            .nav-tabs .nav-link {
                margin-right: 0;
                margin-bottom: 0.5rem;
                font-size: 0.9rem;
            }
            .display-4 {
                font-size: 2rem;
            }
            .card h4 {
                font-size: 1.3rem;
            }
            .card p {
                font-size: 1rem;
            }
            .tab-agua-active {
                margin-top: 500px; /* Reducir el margin-top en móviles para mejor experiencia */
            }
        }
        @media (max-width: 768px) {
            .contenido-centro {
                max-width: 90% !important;
                padding: 1.5rem !important;
            }
            .contenido-centro.tab-agua {
                max-width: 90% !important;
                min-height: 100vh;
            }
            .tab-agua-active {
                margin-top: 700px; /* Ajuste intermedio para tablets */
            }
        }
    </style>

    <!-- JavaScript para animación del contenedor, manejo de margin-top y desplazamiento -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('#alumnoTabs .nav-link');
            const contenidoPrincipal = document.querySelector('.contenido-principal');
            const contenidoCentro = document.querySelector('.contenido-centro');

            tabs.forEach(tab => {
                tab.addEventListener('shown.bs.tab', function (e) {
                    // Añadir o remover la clase tab-agua-active según la pestaña activa
                    if (e.target.id === 'agua-tab') {
                        contenidoPrincipal.classList.add('tab-agua-active');
                        contenidoCentro.classList.add('tab-agua');
                    } else {
                        contenidoPrincipal.classList.remove('tab-agua-active');
                        contenidoCentro.classList.remove('tab-agua');
                    }

                    // Desplazar al inicio del contenedor principal en todas las pestañas
                    contenidoPrincipal.scrollIntoView({ behavior: 'instant', block: 'start' });
                });
            });

            // Activar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Mostrar/ocultar botón de subir
            window.onscroll = function() {
                scrollFunction();
                updateActiveNavLink();
            };
        });

        function scrollFunction() {
            const btnTop = document.getElementById("btnTop");
            if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
                btnTop.style.display = "block";
            } else {
                btnTop.style.display = "none";
            }
        }

        function topFunction() {
            document.getElementById('seccion-bienvenida').scrollIntoView({behavior: 'smooth'});
        }

        // Actualizar enlace activo según scroll
        function updateActiveNavLink() {
            const sections = document.querySelectorAll('section[id]');
            let scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;

            sections.forEach(section => {
                const sectionTop = section.offsetTop - 120;
                const sectionHeight = section.offsetHeight;
                const sectionId = section.getAttribute('id');

                if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                    document.querySelectorAll('#internalNav a').forEach(link => {
                        link.classList.remove('active');
                        if (link.getAttribute('href') === `#${sectionId}`) {
                            link.classList.add('active');
                        }
                    });
                }
            });
        }

        // Click en enlaces de navegación
        document.querySelectorAll('#internalNav a').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelectorAll('#internalNav a').forEach(el => el.classList.remove('active'));
                this.classList.add('active');

                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);

                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 100,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    <div style="width: 100%; background-color: #0d6efd; color: white; text-align: center; padding: 12px 10px; font-weight: bold; font-size: 1.1rem; margin-top: -10px; margin-bottom: 20px; border-radius: 8px;">
    Autor: Juan Francisco Jiménez Garduño - TESVB
</div>



@endsection
