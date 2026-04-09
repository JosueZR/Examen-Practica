<x-app-layout>
    <div class="container py-5 text-center">
        <h1 class="display-4 text-capitalize fw-bold mb-4">{{ $pokemon['name'] }}</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="bg-light p-4 d-flex justify-content-center align-items-center" style="height: 250px;">
                        <img src="{{ $pokemon['sprites']['other']['official-artwork']['front_default'] }}" 
                             alt="{{ $pokemon['name'] }}" 
                             class="img-fluid drop-shadow" style="max-height: 200px;">
                    </div>
                    
                    <div class="card-body bg-white pb-4">
                        <div class="mb-3">
                            <h5 class="fw-bold text-muted mb-2">Tipos</h5>
                            @foreach($pokemon['types'] as $type)
                                <span class="badge bg-danger rounded-pill px-3 py-2 text-capitalize fs-6 mx-1">
                                    {{ $type['type']['name'] }}
                                </span>
                            @endforeach
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h5 class="fw-bold text-muted mb-3">Estadísticas Base</h5>
                            <div class="row text-center">
                                @foreach($pokemon['stats'] as $stat)
                                    @if(in_array($stat['stat']['name'], ['hp', 'attack', 'defense']))
                                        <div class="col-4">
                                            <div class="fw-bold fs-4 text-dark">{{ $stat['base_stat'] }}</div>
                                            <div class="text-uppercase small text-muted fw-bold">{{ $stat['stat']['name'] }}</div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <a href="{{ url('/pokemon') }}" class="btn btn-outline-danger btn-lg px-5 rounded-pill shadow-sm">
                &larr; Volver al catálogo
            </a>
        </div>
    </div>
</x-app-layout>