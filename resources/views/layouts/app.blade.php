<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pokedex') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="{{ asset('css/estilos.css') }}?v={{ time() }}">
    </head>
    <body class="bg-light">
        
        <nav class="navbar navbar-expand-lg pokedex-header">
            <div class="container">
                <div class="pokedex-lights me-4">
                    <div class="light-big-blue"></div>
                    <div class="light-small red"></div>
                    <div class="light-small yellow"></div>
                    <div class="light-small green"></div>
                </div>

                <a class="navbar-brand" href="{{ url('/') }}">POKÉDEX</a>
                
                <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="{{ url('/pokemon') }}">Catálogo</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold font-pixel" style="font-size: 10px;" href="{{ url('/mi-equipo') }}">MI EQUIPO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="{{ url('/about') }}">Acerca de</a>
                        </li>
                        <li class="nav-item ms-3">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-dark btn-sm rounded-pill px-3 font-pixel text-white" style="font-size: 10px;">SALIR</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container mt-5 mb-5 pb-5">
            {{ $slot }}
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>