<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PokeApiService
{
    protected string $baseUrl = 'https://pokeapi.co/api/v2';

    /**
     * Obtiene el listado de Pokémon.
     */
    public function getList(int $limit = 20, int $offset = 0): ?array
    {
        $response = Http::get("{$this->baseUrl}/pokemon", [
            'limit' => $limit,
            'offset' => $offset,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Obtiene los detalles de un Pokémon específico por nombre o ID.
     */
    public function getPokemon(string $nameOrId): ?array
    {
        $response = Http::get("{$this->baseUrl}/pokemon/{$nameOrId}");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}