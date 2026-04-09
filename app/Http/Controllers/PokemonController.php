<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; 
use App\Models\PokemonCapturado; // <-- Nuestro nuevo modelo local
use Illuminate\Support\Facades\Auth;

class PokemonController extends Controller
{
    public function index(Request $request)
    {
        $pokemons = [];
        $errorApi = null;

        try {
            if ($request->has('search')) {
                
                // 1. Usamos el Validador Manual para evitar el bug de redirección
                $validador = \Illuminate\Support\Facades\Validator::make($request->all(), [
                    'search' => 'required'
                ], [
                    'search.required' => 'El campo de búsqueda no puede estar vacío.'
                ]);

                // 2. Si falla la validación, cargamos la vista normal pero inyectando el error rojo
                if ($validador->fails()) {
                    $response = Http::timeout(3)->get('https://pokeapi.co/api/v2/pokemon?limit=20');
                    if ($response->successful()) {
                        $pokemons = $response->json()['results'];
                    }
                    // Mandamos los errores directo a la vista
                    return view('pokemon.index', compact('pokemons', 'errorApi'))->withErrors($validador);
                }

                // 3. Si sí escribió algo, hacemos el filtro de búsqueda
                $searchTerm = strtolower(trim($request->search));
                $response = Http::timeout(3)->get('https://pokeapi.co/api/v2/pokemon?limit=1000');

                if ($response->successful()) {
                    $todos = $response->json()['results'];
                    $resultados = array_filter($todos, function($poke) use ($searchTerm) {
                        return str_contains(strtolower($poke['name']), $searchTerm);
                    });
                    if (count($resultados) > 0) {
                        $pokemons = array_slice($resultados, 0, 20);
                    } else {
                        $errorApi = "No se encontró ningún Pokémon que contenga '{$searchTerm}'.";
                    }
                }
            } else {
                // 4. Si entra sin buscar (carga inicial)
                $response = Http::timeout(3)->get('https://pokeapi.co/api/v2/pokemon?limit=20');
                if ($response->successful()) {
                    $pokemons = $response->json()['results'];
                }
            }
        } catch (\Exception $e) {
            $errorApi = "⚠️ SIN CONEXIÓN A INTERNET. Solo puedes acceder a la sección 'Mi Equipo'.";
        }

        return view('pokemon.index', compact('pokemons', 'errorApi'));
    }

    public function show($name)
    {
        try {
            $response = Http::timeout(3)->get("https://pokeapi.co/api/v2/pokemon/" . strtolower($name));
            if ($response->successful()) {
                $pokemon = $response->json();
                
                // Revisamos si ya lo tenemos guardado en nuestra base de datos local
                $yaCapturado = PokemonCapturado::where('user_id', Auth::id())
                                               ->where('nombre', $pokemon['name'])
                                               ->exists();

                return view('pokemon.show', compact('pokemon', 'yaCapturado'));
            }
        } catch (\Exception $e) {
            return view('pokemon.error', ['name' => $name]);
        }
        return view('pokemon.error', ['name' => $name]);
    }

    // --- NUEVAS FUNCIONES PARA LA BASE DE DATOS LOCAL ---

    public function guardarLocal(Request $request)
    {
        PokemonCapturado::firstOrCreate([
            'user_id' => Auth::id(),
            'nombre' => $request->nombre
        ], [
            'imagen_url' => $request->imagen_url,
            'hp' => $request->hp,
            'attack' => $request->attack,
            'defense' => $request->defense,
            'tipos' => $request->tipos,
            'sonido_url' => $request->sonido_url,
        ]);

        return redirect('/mi-equipo')->with('success', '¡Datos guardados localmente para modo Offline!');
    }

    public function verEquipo()
    {
        // Leemos de SQLite (Esto funcionará aunque no haya internet)
        $pokemonsLocales = PokemonCapturado::where('user_id', Auth::id())->get();
        return view('pokemon.equipo', compact('pokemonsLocales'));
    }

    public function showLocal($id)
    {
        // Buscamos el pokemon en la BD local asegurándonos que sea del usuario actual
        $pokemon = PokemonCapturado::where('user_id', Auth::id())->findOrFail($id);
        
        return view('pokemon.equipo_show', compact('pokemon'));
    }

    public function eliminarLocal($id)
    {
        // 1. Buscamos al Pokémon asegurándonos que sea del usuario actual
        $pokemon = PokemonCapturado::where('user_id', Auth::id())->findOrFail($id);
        
        // 2. Guardamos el nombre para mostrarlo en el mensaje de éxito
        $nombre = strtoupper($pokemon->nombre);
        
        // 3. Lo eliminamos de la base de datos
        $pokemon->delete();

        // 4. Redirigimos a Mi Equipo con un mensaje
        return redirect('/mi-equipo')->with('success', "¡$nombre ha sido liberado de tu equipo!");
    }
}
    