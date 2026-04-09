<x-app-layout>
    <div class="text-center py-5 container">
        <div class="py-5">
            <h1 class="display-1 fw-bold text-danger mb-3">404</h1>
            <h2 class="mb-4">Pokémon no encontrado</h2>
            <p class="lead text-muted mb-5">
                Parece que el Pokémon "<strong>{{ $name }}</strong>" no existe en nuestros registros o hubo un fallo de conexión.
            </p>
            
            <a href="{{ url('/pokemon') }}" class="btn btn-danger btn-lg px-5 rounded-pill shadow">
                &larr; Volver al catálogo
            </a>
        </div>
    </div>
</x-app-layout>