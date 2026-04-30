<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Agregamos tus dos nuevos servicios aquí arriba:
use App\Services\PokeApiService;
use App\Services\PokemonMapper;
use App\Models\PokemonCapturado; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PokemonController extends Controller
{
    // 1. Declaramos las propiedades para los servicios
    protected $pokeApi;
    protected $mapper;

    // 2. Inyectamos los servicios en el constructor
    public function __construct(PokeApiService $pokeApi, PokemonMapper $mapper)
    {
        $this->pokeApi = $pokeApi;
        $this->mapper = $mapper;
    }

    public function index(Request $request)
    {
        $pokemons = [];
        $errorApi = null;

        try {
            if ($request->has('search')) {
                
                // 1. Usamos el Validador Manual para evitar el bug de redirección
                $validador = Validator::make($request->all(), [
                    'search' => 'required'
                ], [
                    'search.required' => 'El campo de búsqueda no puede estar vacío.'
                ]);

                // 2. Si falla la validación
                if ($validador->fails()) {
                    // Usamos el servicio en lugar de Http::get
                    $data = $this->pokeApi->getList(20);
                    if ($data) {
                        $pokemons = $data['results'];
                    }
                    return view('pokemon.index', compact('pokemons', 'errorApi'))->withErrors($validador);
                }

                // 3. Si sí escribió algo, hacemos el filtro de búsqueda
                $searchTerm = strtolower(trim($request->search));
                
                // Usamos el servicio pidiendo 1000
                $data = $this->pokeApi->getList(1000);

                if ($data) {
                    $todos = $data['results'];
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
                $data = $this->pokeApi->getList(20);
                if ($data) {
                    $pokemons = $data['results'];
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
            // 1. Pedimos los datos al Servicio
            $rawData = $this->pokeApi->getPokemon(strtolower($name));
            
            if ($rawData) {
                // 2. Usamos el Mapper para limpiar la data
                $pokemon = $this->mapper->map($rawData);
                
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

    // --- FUNCIONES PARA LA BASE DE DATOS LOCAL (Se quedan igualitas) ---

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
        $pokemonsLocales = PokemonCapturado::where('user_id', Auth::id())->get();
        return view('pokemon.equipo', compact('pokemonsLocales'));
    }

    public function showLocal($id)
    {
        $pokemon = PokemonCapturado::where('user_id', Auth::id())->findOrFail($id);
        return view('pokemon.equipo_show', compact('pokemon'));
    }

    public function eliminarLocal($id)
    {
        $pokemon = PokemonCapturado::where('user_id', Auth::id())->findOrFail($id);
        $nombre = strtoupper($pokemon->nombre);
        $pokemon->delete();

        return redirect('/mi-equipo')->with('success', "¡$nombre ha sido liberado de tu equipo!");
    }
}