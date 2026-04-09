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
                @php $pokeName = strtolower($pokemon['name']); @endphp
                
                <div class="col">
                    <div class="card h-100 text-center poke-card">
                        <div class="p-4 d-flex justify-content-center align-items-center" style="height: 150px;">
                            <img src="https://img.pokemondb.net/sprites/black-white/anim/normal/{{ $pokeName }}.gif" 
                                 alt="{{ $pokeName }}" style="max-height: 80px; object-fit: contain;">
                        </div>
                        
                        <div class="card-body bg-light rounded-bottom d-flex flex-column justify-content-between">
                            <h5 class="card-title text-capitalize fw-bold mb-4 font-pixel" style="font-size: 14px;">{{ $pokeName }}</h5>
                            
                            <a href="{{ url('/pokemon/' . $pokeName) }}" class="btn w-100 btn-poke">
                                VER INFO
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                @if(!isset($errorApi))
                    <div class="col-12 text-center py-5">
                        <h3 class="text-muted">No se encontró ningún Pokémon.</h3>
                    </div>
                @endif
            @endforelse
        </div>
    </div>
</x-app-layout>