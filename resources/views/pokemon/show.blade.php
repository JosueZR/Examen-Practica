<x-app-layout>
    <div class="container py-4">
        
        <div class="d-flex justify-content-center align-items-center gap-2 gap-md-4">
            
            @if($pokemon['id'] > 1)
                <a href="{{ url('/pokemon/' . ($pokemon['id'] - 1)) }}" 
                   class="btn btn-dark rounded-circle shadow border-2 border-warning d-flex align-items-center justify-content-center text-warning" 
                   style="width: 50px; height: 50px; font-size: 20px; text-decoration: none; transition: transform 0.2s;"
                   onmouseover="this.style.transform='scale(1.1)'" 
                   onmouseout="this.style.transform='scale(1)'">
                    &#9664;
                </a>
            @else
                <div style="width: 50px; height: 50px;"></div>
            @endif

            <div style="max-width: 480px; width: 100%;">
                
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden poke-card">
                    
                    <div class="bg-dark text-white p-3 d-flex justify-content-between align-items-center border-bottom border-4 border-dark">
                        <h2 class="text-capitalize mb-0 font-pixel text-warning" style="font-size: 18px;">{{ $pokemon['name'] }}</h2>
                        <span class="font-pixel text-muted" style="font-size: 14px;">#{{ str_pad($pokemon['id'], 3, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="p-4 d-flex justify-content-center align-items-center" style="background: radial-gradient(circle, #f8f9fa 0%, #e9ecef 100%); height: 300px;">
                        <img src="{{ $pokemon['image'] }}" 
                            alt="{{ $pokemon['name'] }}" class="img-fluid" 
                            style="max-height: 250px; filter: drop-shadow(5px 5px 10px rgba(0,0,0,0.3)); transition: transform 0.3s;"
                            onmouseover="this.style.transform='scale(1.15)'" onmouseout="this.style.transform='scale(1)'">
                    </div>
                    
                    <div class="bg-dark text-center py-2 border-bottom border-dark">
                        <audio id="poke-cry" src="{{ $pokemon['cry'] }}"></audio>
                        <button type="button" onclick="document.getElementById('poke-cry').play()" class="btn btn-warning font-pixel rounded-pill border border-dark shadow-sm" style="font-size: 10px;">
                            🔊 REPRODUCIR SONIDO
                        </button>
                    </div>

                    <div class="bg-light text-center py-2 border-bottom border-dark position-relative">
                        
                        <div id="pokeball-container">
                            <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png" alt="Pokebola" class="bola-img">
                        </div>

                        @if($yaCapturado)
                            <span class="badge bg-success font-pixel py-2 px-3 shadow-sm border border-dark">¡YA ESTÁ EN TU EQUIPO!</span>
                        @else
                            <form id="capture-form" action="{{ url('/pokemon/guardar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="nombre" value="{{ $pokemon['name'] }}">
                                <input type="hidden" name="imagen_url" value="{{ $pokemon['image'] }}">
                                <input type="hidden" name="hp" value="{{ $pokemon['hp'] }}">
                                <input type="hidden" name="attack" value="{{ $pokemon['attack'] }}">
                                <input type="hidden" name="defense" value="{{ $pokemon['defense'] }}">
                                <input type="hidden" name="tipos" value="{{ implode(', ', $pokemon['types']) }}">
                                <input type="hidden" name="sonido_url" value="{{ $pokemon['cry'] }}">
                                
                                <button type="button" onclick="lanzarPokebolaYCapturar()" class="btn btn-danger font-pixel rounded-pill border-dark">
                                    🔴 CAPTURAR (GUARDAR)
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    <div class="card-body bg-white p-4">
                        <div class="mb-4 text-center">
                            @php
                                $coloresTipos = [
                                    'normal' => '#A8A77A', 'fire' => '#EE8130', 'water' => '#6390F0', 'electric' => '#F7D02C', 'grass' => '#7AC74C', 'ice' => '#96D9D6', 'fighting' => '#C22E28', 'poison' => '#A33EA1', 'ground' => '#E2BF65', 'flying' => '#A98FF3', 'psychic' => '#F95587', 'bug' => '#A6B91A', 'rock' => '#B6A136', 'ghost' => '#735797', 'dragon' => '#6F35FC', 'dark' => '#705746', 'steel' => '#B7B7CE', 'fairy' => '#D685AD'
                                ];
                            @endphp
                            
                            @foreach($pokemon['types'] as $type)
                                <span class="badge rounded-pill px-4 py-2 text-capitalize text-white shadow-sm mx-1 font-pixel" style="background-color: {{ $coloresTipos[$type] ?? '#777' }}; font-size: 12px;">
                                    {{ $type }}
                                </span>
                            @endforeach
                        </div>

                        <hr class="mb-4" style="border-top: 2px dashed #ccc;">

                        <div class="mb-2">
                            <h5 class="fw-bold text-muted mb-4 font-pixel text-center" style="font-size: 14px;">ESTADÍSTICAS</h5>
                            
                            <!-- HP -->
                            @php $porcentajeHp = min(($pokemon['hp'] / 150) * 100, 100); @endphp
                            <div class="d-flex align-items-center mb-3">
                                <span class="text-uppercase fw-bold text-secondary font-pixel text-end me-2" style="width: 75px; font-size: 10px;">HP</span>
                                <span class="fw-bold text-dark font-pixel text-center me-2" style="width: 35px; font-size: 10px;">{{ $pokemon['hp'] }}</span>
                                <div class="progress flex-grow-1 border border-dark bg-light shadow-inner" style="height: 18px; border-radius: 4px;">
                                    <div class="progress-bar bg-success" style="width: {{ $porcentajeHp }}%"></div>
                                </div>
                            </div>

                            <!-- ATTACK -->
                            @php $porcentajeAtk = min(($pokemon['attack'] / 150) * 100, 100); @endphp
                            <div class="d-flex align-items-center mb-3">
                                <span class="text-uppercase fw-bold text-secondary font-pixel text-end me-2" style="width: 75px; font-size: 10px;">ATTACK</span>
                                <span class="fw-bold text-dark font-pixel text-center me-2" style="width: 35px; font-size: 10px;">{{ $pokemon['attack'] }}</span>
                                <div class="progress flex-grow-1 border border-dark bg-light shadow-inner" style="height: 18px; border-radius: 4px;">
                                    <div class="progress-bar bg-danger" style="width: {{ $porcentajeAtk }}%"></div>
                                </div>
                            </div>

                            <!-- DEFENSE -->
                            @php $porcentajeDef = min(($pokemon['defense'] / 150) * 100, 100); @endphp
                            <div class="d-flex align-items-center mb-3">
                                <span class="text-uppercase fw-bold text-secondary font-pixel text-end me-2" style="width: 75px; font-size: 10px;">DEFENSE</span>
                                <span class="fw-bold text-dark font-pixel text-center me-2" style="width: 35px; font-size: 10px;">{{ $pokemon['defense'] }}</span>
                                <div class="progress flex-grow-1 border border-dark bg-light shadow-inner" style="height: 18px; border-radius: 4px;">
                                    <div class="progress-bar bg-info" style="width: {{ $porcentajeDef }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-4 text-center mb-5">
                    <a href="{{ url('/pokemon') }}" class="btn btn-poke px-5 py-3 fs-6 rounded-pill">
                        &larr; REGRESAR AL CATÁLOGO
                    </a>
                </div>

            </div>

            <a href="{{ url('/pokemon/' . ($pokemon['id'] + 1)) }}" 
               class="btn btn-dark rounded-circle shadow border-2 border-warning d-flex align-items-center justify-content-center text-warning" 
               style="width: 50px; height: 50px; font-size: 20px; text-decoration: none; transition: transform 0.2s;"
               onmouseover="this.style.transform='scale(1.1)'" 
               onmouseout="this.style.transform='scale(1)'">
                &#9654;
            </a>

        </div>
    </div>

    <style>
        /* Ocultamos la pokebola usando opacidad en vez de display, para evitar bugs de animación */
        #pokeball-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 99999; /* Por encima de toda la página */
            pointer-events: none;
            opacity: 0; 
        }

        /* Cuando le damos clic, se activa esta clase */
        .pokeball-throwing {
            animation: throwArc 1.5s ease-out forwards;
        }

        .pokeball-throwing .bola-img {
            width: 80px; /* Tamaño grande y nítido */
            animation: spinBall 0.4s linear infinite;
        }

        /* Vuelo curvo de la pokebola */
        @keyframes throwArc {
            0%   { transform: translate(-50%, 250px) scale(0.3); opacity: 0; }
            15%  { opacity: 1; transform: translate(-50%, -100px) scale(1.5); }
            50%  { opacity: 1; transform: translate(-50%, 0px) scale(1.2); }
            80%  { opacity: 1; transform: translate(-50%, 20px) scale(1); }
            100% { transform: translate(-50%, 60px) scale(0); opacity: 0; }
        }

        /* Giro de la pokebola */
        @keyframes spinBall {
            0%   { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <script>
        function lanzarPokebolaYCapturar() {
            const form = document.getElementById('capture-form');
            const pokeball = document.getElementById('pokeball-container');
            
            // 1. Reproduce el grito del Pokémon
            document.getElementById('poke-cry').play();

            // 2. Dispara la animación visual de la pokebola
            pokeball.classList.add('pokeball-throwing');

            // 3. Espera 1.5 segundos (lo que dura el vuelo) y luego envía el formulario para guardar
            setTimeout(function() {
                pokeball.classList.remove('pokeball-throwing');
                form.submit();
            }, 1500);
        }
    </script>
</x-app-layout>