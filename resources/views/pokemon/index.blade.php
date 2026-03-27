<x-app-layout>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4 text-center fw-bold">Pokémon</h2>
            
            <div class="list-group shadow-sm">
                @foreach($pokemons as $pokemon)
                    <a href="{{ url('/pokemon/' . strtolower($pokemon)) }}" class="list-group-item list-group-item-action text-capitalize">
                        {{ $pokemon }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>