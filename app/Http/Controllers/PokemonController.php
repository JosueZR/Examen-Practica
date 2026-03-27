<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PokemonController extends Controller
{
    // Método para mostrar el listado (Requisito de la rúbrica)
    public function index()
    {
        // Arreglo prueba de 12 pokémon
        $pokemons = [
            'Bulbasaur', 'Ivysaur', 'Venusaur', 'Charmander', 
            'Charmeleon', 'Charizard', 'Squirtle', 'Wartortle', 
            'Blastoise', 'Caterpie', 'Metapod', 'Butterfree'
        ];

        return view('pokemon.index', compact('pokemons'));
    }

    // Método para mostrar el detalle de un solo pokémon
    public function show($name)
    {
        return view('pokemon.show', compact('name'));
    }
}