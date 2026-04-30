<?php

namespace App\Services;

class PokemonMapper
{
    /**
     * Recibe el JSON decodificado (array) de la PokéAPI y devuelve la estructura limpia.
     */
    public function map(array $apiData): array
    {
        $stats = [];
        if (isset($apiData['stats'])) {
            foreach ($apiData['stats'] as $stat) {
                $stats[$stat['stat']['name']] = $stat['base_stat'];
            }
        }

        $types = [];
        if (isset($apiData['types'])) {
            foreach ($apiData['types'] as $type) {
                $types[] = $type['type']['name'];
            }
        }

        return [
            'id'      => $apiData['id'] ?? 0,
            'name'    => isset($apiData['name']) ? strtolower(trim($apiData['name'])) : 'Unknown',
            // Sprite chiquito normal
            'sprite'  => $apiData['sprites']['front_default'] ?? null,
            // Imagen en alta calidad (la que pide tu vista)
            'image'   => $apiData['sprites']['other']['official-artwork']['front_default'] ?? null,
            // Sonido del Pokémon
            'cry'     => $apiData['cries']['latest'] ?? null,
            'types'   => $types,
            'hp'      => $stats['hp'] ?? 0,
            'attack'  => $stats['attack'] ?? 0,
            'defense' => $stats['defense'] ?? 0,
        ];
    }
}