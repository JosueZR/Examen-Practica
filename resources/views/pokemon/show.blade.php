<x-app-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden poke-card">
                    
                    <div class="bg-dark text-white p-3 d-flex justify-content-between align-items-center border-bottom border-4 border-dark">
                        <h2 class="text-capitalize mb-0 font-pixel text-warning" style="font-size: 18px;">{{ $pokemon['name'] }}</h2>
                        <span class="font-pixel text-muted" style="font-size: 14px;">#{{ str_pad($pokemon['id'], 3, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="p-4 d-flex justify-content-center align-items-center" style="background: radial-gradient(circle, #f8f9fa 0%, #e9ecef 100%); height: 300px;">
                        <img src="{{ $pokemon['sprites']['other']['official-artwork']['front_default'] }}" 
                             alt="{{ $pokemon['name'] }}" 
                             class="img-fluid" 
                             style="max-height: 250px; filter: drop-shadow(5px 5px 10px rgba(0,0,0,0.3)); transition: transform 0.3s;"
                             onmouseover="this.style.transform='scale(1.15)'"
                             onmouseout="this.style.transform='scale(1)'">
                    </div>
                    
                    <div class="card-body bg-white p-4">
                        
                        <div class="mb-4 text-center">
                            @php
                                // Diccionario mágico de colores Pokémon
                                $coloresTipos = [
                                    'normal' => '#A8A77A', 'fire' => '#EE8130', 'water' => '#6390F0',
                                    'electric' => '#F7D02C', 'grass' => '#7AC74C', 'ice' => '#96D9D6',
                                    'fighting' => '#C22E28', 'poison' => '#A33EA1', 'ground' => '#E2BF65',
                                    'flying' => '#A98FF3', 'psychic' => '#F95587', 'bug' => '#A6B91A',
                                    'rock' => '#B6A136', 'ghost' => '#735797', 'dragon' => '#6F35FC',
                                    'dark' => '#705746', 'steel' => '#B7B7CE', 'fairy' => '#D685AD'
                                ];
                            @endphp
                            
                            @foreach($pokemon['types'] as $type)
                                <span class="badge rounded-pill px-4 py-2 text-capitalize text-white shadow-sm mx-1 font-pixel" 
                                      style="font-size: 10px; background-color: {{ $coloresTipos[$type['type']['name']] ?? '#777' }}; border: 2px solid rgba(0,0,0,0.2);">
                                    {{ $type['type']['name'] }}
                                </span>
                            @endforeach
                        </div>

                        <hr class="mb-4" style="border-top: 2px dashed #ccc;">

                        <div class="mb-2">
                            <h5 class="fw-bold text-muted mb-4 font-pixel text-center" style="font-size: 14px;">ESTADÍSTICAS</h5>
                            
                            @foreach($pokemon['stats'] as $stat)
                                @if(in_array($stat['stat']['name'], ['hp', 'attack', 'defense']))
                                    @php
                                        // Calculamos qué porcentaje de la barra se debe llenar (max 150 para que se vea bien)
                                        $porcentaje = min(($stat['base_stat'] / 150) * 100, 100); 
                                        
                                        // Asignamos un color diferente a cada stat
                                        $colorBarra = 'bg-success'; // Verde para HP
                                        if($stat['stat']['name'] == 'attack') $colorBarra = 'bg-danger'; // Rojo para Ataque
                                        if($stat['stat']['name'] == 'defense') $colorBarra = 'bg-info'; // Azul para Defensa
                                    @endphp
                                    
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="text-uppercase fw-bold text-secondary font-pixel text-end me-2" style="width: 75px; font-size: 8px;">
                                            {{ $stat['stat']['name'] }}
                                        </span>
                                        
                                        <span class="fw-bold text-dark font-pixel text-center me-2" style="width: 35px; font-size: 10px;">
                                            {{ str_pad($stat['base_stat'], 3, '0', STR_PAD_LEFT) }}
                                        </span>
                                        
                                        <div class="progress flex-grow-1 border border-dark bg-light shadow-inner" style="height: 18px; border-radius: 10px;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated {{ $colorBarra }}" 
                                                 role="progressbar" 
                                                 style="width: {{ $porcentaje }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>

                <div class="mt-4 text-center mb-5">
                    <a href="{{ url('/pokemon') }}" class="btn btn-poke px-5 py-3 fs-6 rounded-pill">
                        &larr; REGRESAR AL CATÁLOGO
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>