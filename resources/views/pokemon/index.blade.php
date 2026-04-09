<x-app-layout>
    <div class="container py-4">
        <h2 class="mb-4 text-center fw-bold display-5">Catálogo Pokémon</h2>
        
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <form action="{{ url('/pokemon') }}" method="GET" class="shadow-sm">
                    <div class="input-group input-group-lg">
                        <input type="text" name="search" class="form-control @error('search') is-invalid @enderror" 
                               placeholder="Buscar Pokémon por nombre" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-danger px-4 fw-bold">Buscar</button>
                    </div>
                    
                    @error('search')
                        <div class="text-danger mt-2 fw-bold">{{ $message }}</div>
                    @enderror
                </form>
                
                @if(request()->has('search'))
                    <div class="text-center mt-3">
                        <a href="{{ url('/pokemon') }}" class="text-decoration-none text-muted">Limpiar búsqueda</a>
                    </div>
                @endif
            </div>
        </div>

        @if(isset($errorApi))
            <div class="alert alert-warning text-center shadow-sm fw-bold">
                {{ $errorApi }}
            </div>
        @endif

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($pokemons as $pokemon)
                @php 
                    $pokeName = strtolower($pokemon['name']); 
                    
                    // Magia: Extraemos el ID del Pokémon desde su URL para conseguir su foto oficial
                    $urlParts = explode('/', rtrim($pokemon['url'], '/'));
                    $pokeId = end($urlParts);
                    $imagenOficial = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/{$pokeId}.png";
                @endphp
                
                <div class="col">
                    <div class="card h-100 text-center poke-card">
                        <div class="p-4 d-flex justify-content-center align-items-center border-bottom border-dark" style="height: 180px; background: radial-gradient(circle, #f8f9fa 0%, #e9ecef 100%);">
                            <img src="{{ $imagenOficial }}" 
                                 alt="{{ $pokeName }}" 
                                 class="img-fluid drop-shadow" style="max-height: 120px; transition: transform 0.3s;">
                        </div>
                        
                        <div class="card-body bg-light rounded-bottom d-flex flex-column justify-content-between">
                            <h5 class="card-title text-capitalize fw-bold mb-4 font-pixel text-dark" style="font-size: 14px;">{{ $pokeName }}</h5>
                            
                            <a href="{{ url('/pokemon/' . $pokeName) }}" class="btn w-100 btn-poke">
                                VER INFO
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                @if(!isset($errorApi))
                    <div class="col-12 text-center py-5">
                        <h3 class="text-muted font-pixel">No se encontró ningún Pokémon.</h3>
                    </div>
                @endif
            @endforelse
        </div>
    </div>
</x-app-layout>