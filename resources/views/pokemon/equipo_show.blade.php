<x-app-layout>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden poke-card">
                    
                    <div class="bg-dark text-white p-3 d-flex justify-content-between align-items-center border-bottom border-4 border-dark">
                        <h2 class="text-capitalize mb-0 font-pixel text-warning" style="font-size: 18px;">{{ $pokemon->nombre }}</h2>
                        <span class="badge bg-success font-pixel" style="font-size: 8px;">MODO OFFLINE</span>
                    </div>


                    <div class="p-4 d-flex justify-content-center align-items-center" style="background: radial-gradient(circle, #f8f9fa 0%, #e9ecef 100%); height: 300px;">
                        <img src="{{ $pokemon->imagen_url }}" alt="{{ $pokemon->nombre }}" class="img-fluid" style="max-height: 250px; filter: drop-shadow(5px 5px 10px rgba(0,0,0,0.3));">
                    </div>

                    @if($pokemon->sonido_url)
                        <div class="bg-dark text-center py-2 border-bottom border-dark">
                            <audio id="poke-cry-local" src="{{ $pokemon->sonido_url }}"></audio>
                            <button type="button" onclick="document.getElementById('poke-cry-local').play()" class="btn btn-warning font-pixel rounded-pill border border-dark shadow-sm" style="font-size: 10px;">
                                🔊 REPRODUCIR SONIDO (OFFLINE)
                            </button>
                        </div>
                    @endif
                    <div class="card-body bg-white p-4">
                        
                        <div class="mb-4 text-center">
                            @php
                                $tiposArray = explode(', ', $pokemon->tipos);
                                $coloresTipos = [
                                    'normal' => '#A8A77A', 'fire' => '#EE8130', 'water' => '#6390F0',
                                    'electric' => '#F7D02C', 'grass' => '#7AC74C', 'ice' => '#96D9D6',
                                    'fighting' => '#C22E28', 'poison' => '#A33EA1', 'ground' => '#E2BF65',
                                    'flying' => '#A98FF3', 'psychic' => '#F95587', 'bug' => '#A6B91A',
                                    'rock' => '#B6A136', 'ghost' => '#735797', 'dragon' => '#6F35FC',
                                    'dark' => '#705746', 'steel' => '#B7B7CE', 'fairy' => '#D685AD'
                                ];
                            @endphp
                            
                            @foreach($tiposArray as $tipo)
                                <span class="badge rounded-pill px-4 py-2 text-capitalize text-white shadow-sm mx-1 font-pixel" 
                                      style="font-size: 10px; background-color: {{ $coloresTipos[trim($tipo)] ?? '#777' }}; border: 2px solid rgba(0,0,0,0.2);">
                                    {{ $tipo }}
                                </span>
                            @endforeach
                        </div>

                        <hr class="mb-4" style="border-top: 2px dashed #ccc;">

                        <div class="mb-2">
                            <h5 class="fw-bold text-muted mb-4 font-pixel text-center" style="font-size: 12px;">ESTADÍSTICAS GUARDADAS</h5>
                            
                            @foreach(['hp' => 'bg-success', 'attack' => 'bg-danger', 'defense' => 'bg-info'] as $stat => $color)
                                <div class="d-flex align-items-center mb-3">
                                    <span class="text-uppercase fw-bold text-secondary font-pixel text-end me-2" style="width: 75px; font-size: 8px;">{{ $stat }}</span>
                                    <span class="fw-bold text-dark font-pixel text-center me-2" style="width: 35px; font-size: 10px;">{{ $pokemon->$stat }}</span>
                                    <div class="progress flex-grow-1 border border-dark bg-light" style="height: 18px; border-radius: 10px;">
                                        <div class="progress-bar progress-bar-striped {{ $color }}" 
                                             style="width: {{ ($pokemon->$stat / 150) * 100 }}%"></div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                    </div>
                </div>
                <hr class="my-4" style="border-top: 2px dashed #ccc;">

                        <div class="text-center">
                            <form action="{{ url('/mi-equipo/' . $pokemon->id) }}" method="POST" 
                                  onsubmit="return confirm('¿Estás seguro de que deseas liberar a {{ strtoupper($pokemon->nombre) }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger font-pixel w-100 py-3" style="font-size: 10px; border-radius: 50px; border-width: 3px;">
                                    ❌ LIBERAR POKÉMON DE LA BASE DE DATOS
                                </button>
                            </form>
                        </div>
                    </div> </div> <div class="mt-4 text-center">
                    <a href="{{ url('/mi-equipo') }}" class="btn btn-poke px-5 rounded-pill shadow-sm">
                        &larr; VOLVER A MI EQUIPO
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>