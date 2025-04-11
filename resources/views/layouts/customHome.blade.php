<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Plataforma</title>

    <link rel="stylesheet" href="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('startbootstrap-sb-admin-2-gh-pages/css/sb-admin-2.min.css') }}">

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
            background-color: #fef7e7;
            background-image: url("{{ asset('img/fondo.png') }}");
            background-repeat: no-repeat;
            background-position: center center;
            background-size: 1550px 720px; /* tamaño exacto que quieres */
        }

        .contenido-centro {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1;
            background-color: #9fc6c1; /* fondo blanco semiopaco */
            padding: 2rem;
            border-radius: 1rem;
            width: 100%;
            max-width: 950px;
        }

        .login-overlay .card {
            padding: 16px 20px;
            border-radius: 1.5rem;
            background-color: #fef7e7;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: none;
        }


    </style>

</head>
<body>
<div class="contenido-centro">
    @yield('content')
</div>

<script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>


</html>
