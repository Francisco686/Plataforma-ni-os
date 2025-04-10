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
            background: url("{{ asset('img/benito.png') }}") no-repeat center center fixed;
            background-size: 100%  100%;
            background-color: #f8f9fc;
        }

        .login-overlay {
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            max-width: 360px;
            padding: 0;
        }

        .login-overlay .card {
            padding: 16px 20px;
            border-radius: 1.5rem;
            background-color: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border: none;
        }

        .btn {
            white-space: normal !important;
        }
    </style>
</head>
<body>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-100" style="max-width: 600px;">
        @yield('content')
    </div>
</div>

<script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('startbootstrap-sb-admin-2-gh-pages/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
