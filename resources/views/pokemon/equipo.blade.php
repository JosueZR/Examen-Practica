<x-app-layout>
    <div class="container py-4">
        
        <div class="bg-dark text-white p-3 border-4 border-dark text-center mb-5 rounded shadow">
            <h2 class="mb-0 font-pixel text-warning display-6">MI EQUIPO POKÉMON</h2>
            <p class="mb-0 mt-2 text-success font-pixel" style="font-size: 10px;">DATOS LOCALES (OFFLINE) ACTIVADOS</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success font-pixel text-center shadow-sm" style="font-size: 12px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse($pokemonsLocales as $pokemon)
                <div class="col">
                    <div class="card h-100 text-center poke-card">
                        <div class="p-3 d-flex justify-content-center align-items-center" style="height: 180px; background: radial-gradient(circle, #f8f9fa 0%, #e9ecef 100%);">
                            <img src="{{ $pokemon->imagen_url }}" class="img-fluid" style="max-height: 140px;">
                        </div>
                        <div class="card-body bg-light rounded-bottom d-flex flex-column">
                            <h5 class="card-title text-capitalize fw-bold mb-0 font-pixel text-center" style="font-size: 14px;">{{ $pokemon->nombre }}</h5>
                            <small class="text-muted font-pixel mt-2 mb-3 text-center" style="font-size: 8px;">Guardado en SQLite</small>
                            
                            <div class="d-grid gap-2">
                                <a href="{{ url('/mi-equipo/' . $pokemon->id) }}" class="btn btn-poke w-100">
                                    VER INFO
                                </a>

                                <form action="{{ url('/mi-equipo/' . $pokemon->id) }}" method="POST" class="w-100" 
                                    onsubmit="return confirm('¿Estás seguro de que deseas liberar a {{ strtoupper($pokemon->nombre) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100 font-pixel shadow-sm border border-dark" style="font-size: 8px; padding: 10px; border-radius: 50px;">
                                        ❌ LIBERAR
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h3 class="text-muted font-pixel">Aún no has capturado ningún Pokémon.</h3>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>