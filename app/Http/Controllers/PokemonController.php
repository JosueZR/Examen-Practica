<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // <-- ¡Línea nueva y obligatoria!

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        $pokemons = [];
        $errorApi = null;

        if ($request->has('search')) {
            // Validación obligatoria
            $request->validate(['search' => 'required'], [
                'search.required' => 'El campo de búsqueda no puede estar vacío.'
            ]);

            $searchTerm = strtolower($request->search);
            
            // Consumir API buscando un solo Pokémon
            $response = Http::get("https://pokeapi.co/api/v2/pokemon/{$searchTerm}");

            if ($response->successful()) {
                // Lo guardamos con la misma estructura para la vista
                $pokemons[] = ['name' => $response->json()['name']];
            } else {
                $errorApi = "No se encontró ningún Pokémon llamado '{$searchTerm}'.";
            }
        } else {
            // Consumir la API para traer 20 Pokémon (Requisito)
            $response = Http::get('https://pokeapi.co/api/v2/pokemon?limit=20');
            
            if ($response->successful()) {
                $pokemons = $response->json()['results'];
            } else {
                $errorApi = "Hubo un error al conectar con la PokéAPI.";
            }
        }

        return view('pokemon.index', compact('pokemons', 'errorApi'));
    }

    public function show($name)
    {
        // Consumir el detalle del Pokémon (Requisito)
        $response = Http::get("https://pokeapi.co/api/v2/pokemon/" . strtolower($name));

        if ($response->successful()) {
            $pokemon = $response->json();
            return view('pokemon.show', compact('pokemon'));
        }

        // Si falla o no existe, mandamos a una vista de error amigable (Requisito)
        return view('pokemon.error', ['name' => $name]);
    }
}