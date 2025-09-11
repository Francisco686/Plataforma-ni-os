@extends('layouts.app')

@section('content')
    <style>
        body {
            background: linear-gradient(to bottom, #c6f3ff, #ffffff);
            font-family: 'Comic Sans MS', cursive, sans-serif;
            overflow-x: hidden;
        }

        h2 {
            font-size: 3.5rem;
            color: #0d6efd;
            font-weight: 900;
            text-shadow: 2px 2px #d0f0ff;
            margin-bottom: 2rem;
            text-align: center;
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .nav-tabs {
            border-bottom: 2px solid #0d6efd;
            margin-bottom: 2rem;
        }

        .nav-tabs .nav-link {
            font-size: 1.4rem;
            color: #495057;
            font-weight: 600;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 1rem 1rem 0 0;
            transition: all 0.3s ease;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }

        .nav-tabs .nav-link.active {
            background-color: #0d6efd;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
        }

        .nav-tabs .nav-link:hover {
            background-color: #e9ecef;
            color: #0d6efd;
        }

        .game-stats-card {
            border-radius: 1.5rem;
            background: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            padding: 1.5rem;
            height: 100%;
            transition: box-shadow 0.3s ease;
            background: linear-gradient(135deg, #ffffff, #f0f8ff);
        }

        .game-stats-card:hover {
            box-shadow: 0 12px 30px rgba(0, 123, 255, 0.3);
        }

        .game-stats-card h4 {
            font-size: 1.6rem;
            color: #333;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
        }

        .game-stats-card p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .game-stats-card .icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .sopa-card { border-left: 4px solid #22c55e; }
        .memorama-card { border-left: 4px solid #ff8eb8; }
        .clasificacion-card { border-left: 4px solid #ffd166; }

        .achievements-card {
            border-radius: 1.5rem;
            background: white;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 2px dashed #ddd;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .achievements-card h3 {
            font-size: 2rem;
            color: #0d6efd;
            font-weight: 700;
            text-shadow: 1px 1px #d0f0ff;
            margin-bottom: 1.5rem;
        }

        .achievement-card {
            border-radius: 1rem;
            background: #f8f9fa;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            border: 1px solid #ddd;
            position: relative;
        }

        .achievement-card:hover {
            box-shadow: 0 6px 15px rgba(0, 123, 255, 0.2);
        }

        .achievement-card img {
            height: 100px;
            object-fit: contain;
            padding: 1rem;
        }

        .achievement-card .card-body {
            padding: 1.5rem;
        }

        .achievement-card .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }

        .achievement-card .card-text {
            font-size: 0.95rem;
            color: #555;
        }

        .achievement-card .text-success {
            font-size: 0.9rem;
            font-weight: 500;
        }

        .locked-achievement {
            opacity: 0.5;
            position: relative;
        }

        .locked-achievement::after {
            content: '\f023';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 2.5rem;
            color: #dc3545;
            text-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
        }

        .no-achievements {
            font-size: 1.2rem;
            color: #555;
            text-align: center;
            padding: 2rem;
            background: #f8d7da;
            border-radius: 1rem;
            border: 2px dashed #dc3545;
        }

        .btn-back {
            font-size: 1.1rem;
            padding: 0.8rem 1.8rem;
            border-radius: 1rem;
            background-color: #22c55e;
            color: white;
            font-family: 'Comic Sans MS', cursive, sans-serif;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #15803d;
        }

        @media (max-width: 768px) {
            h2 {
                font-size: 2.5rem;
            }

            .game-stats-card {
                padding: 1rem;
            }

            .game-stats-card h4 {
                font-size: 1.4rem;
            }

            .game-stats-card p {
                font-size: 1rem;
            }

            .game-stats-card .icon {
                font-size: 2rem;
            }

            .achievements-card {
                padding: 1.5rem;
            }

            .achievements-card h3 {
                font-size: 1.5rem;
            }

            .nav-tabs .nav-link {
                font-size: 1.1rem;
                padding: 0.6rem 1.5rem;
            }

            .achievement-card img {
                height: 80px;
            }

            .achievement-card .card-title {
                font-size: 1.1rem;
            }

            .achievement-card .card-text {
                font-size: 0.85rem;
            }

            .locked-achievement::after {
                font-size: 2rem;
            }
        }
    </style>

    <div class="container py-4">
        <!-- Botón de regreso -->
        <div class="mb-4">
            <a href="{{ route('home') }}" class="btn btn-back shadow">
                <i class="fas fa-arrow-left me-2"></i> Regresar al Inicio
            </a>
        </div>
///Contenido de logros///

        </div>
    </div>

    <!-- Bootstrap JS for Tabs -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
@endsection
