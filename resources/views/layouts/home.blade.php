<x-app-layout>
    <div class="text-center py-5">
        <img src="https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/items/poke-ball.png" alt="Pokeball" width="100" class="mb-3">
        
        <h1 class="display-4 fw-bold text-dark mb-4">¡Bienvenido a la Pokédex Web!</h1>
        <p class="lead text-muted mb-5">
            Explora, busca y descubre información sobre tus Pokémon favoritos.
        </p>

        <a href="{{ url('/pokemon') }}" class="btn btn-danger btn-lg px-5 rounded-pill shadow">
            Entrar a la Pokédex
        </a>
    </div>
</x-app-layout>