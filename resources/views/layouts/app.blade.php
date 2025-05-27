<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Plataforma Educativa Ambiental</title>
    <meta name="description" content="Accede a la plataforma educativa interactiva sobre conciencia ambiental para niños de primaria.">
    <meta name="keywords" content="iniciar sesión, plataforma niños, conciencia ambiental, educación primaria, ecología">

    <link rel="stylesheet" href="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css') }}">

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: auto;
            min-height: 100vh;
            background-color: #f8f9fc;
            background-image: url("{{ asset('img/fondo2.png') }}");
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 1550px 750px;
        }

        .contenido-centro_login {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            background-color: rgba(253, 254, 249, 0.6);  /* Fondo semitransparente */
            padding: 2rem;
            border-radius: 1rem;
            width: 100%;
            max-width: 700px;
            background-position: center top;
            background-size: cover;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .contenido-centro {
            position: absolute;
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            background-color: rgba(253, 254, 249, 0.6);  /* Fondo semitransparente */
            padding: 2rem;
            border-radius: 1rem;
            width: 100%;
            max-width: 1280px;
            background-position: center top;
            background-size: cover;
            overflow-x: hidden;
            overflow-y: auto;
        }

        main {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .card {
            border-radius: 1rem;
            margin-bottom: 1.5rem; /* Espacio entre tarjetas */
        }


        .contenido-centro .card {
            margin-right: 1rem;
            margin-left: 1rem;
        }


        .card:hover {
            transform: translateY(-5px);
            transition: 0.3s ease;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
<div class="@yield('clase-centro')">
    @yield('content')
</div>


<script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
