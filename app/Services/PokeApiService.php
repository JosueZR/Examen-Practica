<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PokeApiService
{
    // Función auxiliar para generar la llave del caché
    public function getCacheKey($name)
    {
        return "pokemon_detail_" . strtolower($name);
    }

    public function getPokemon($name)
    {
        $key = $this->getCacheKey($name);

        // Si existe en caché, lo devuelve. Si no, hace la petición y lo guarda por 300 segundos (5 min)
        return Cache::remember($key, 300, function () use ($name) {
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$name}");
            
            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });
    }

    public function getList($limit = 20)
    {
        $response = Http::get("https://pokeapi.co/api/v2/pokemon?limit={$limit}");
        return $response->successful() ? $response->json() : null;
    }
}