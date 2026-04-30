<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PokemonRoutesTest extends TestCase
{
    // Esto asegura que la base de datos de pruebas se limpie y no afecte tus datos reales
    use RefreshDatabase; 

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Creamos un usuario falso de prueba en la base de datos en memoria
        $this->user = User::factory()->create();
    }

    /**
     * 1. GET / responde 200 (Home).
     */
    public function test_home_responde_200(): void
    {
        // actingAs() simula que este usuario ya inició sesión
        $response = $this->actingAs($this->user)->get('/');

        $response->assertStatus(200);
    }

    /**
     * 2. GET /pokemon responde 200 (Listado).
     */
    public function test_listado_pokemon_responde_200(): void
    {
        Http::fake([
            'pokeapi.co/api/v2/pokemon*' => Http::response([
                'results' => [['name' => 'bulbasaur', 'url' => '...']]
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/pokemon');

        $response->assertStatus(200);
        $response->assertViewIs('pokemon.index');
    }

    /**
     * 3. GET /about responde 200 (Acerca de).
     */
    public function test_about_responde_200(): void
    {
        $response = $this->actingAs($this->user)->get('/about');

        $response->assertStatus(200);
    }

    /**
     * 4. GET /pokemon/pikachu (nombre válido) responde 200.
     */
    public function test_pokemon_valido_responde_200(): void
    {
        Http::fake([
            'pokeapi.co/api/v2/pokemon/pikachu' => Http::response([
                'id' => 25,
                'name' => 'pikachu',
                'sprites' => [
                    'front_default' => 'url',
                    'other' => ['official-artwork' => ['front_default' => 'url']]
                ],
                'cries' => ['latest' => 'url'],
                'types' => [],
                'stats' => []
            ], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/pokemon/pikachu');

        $response->assertStatus(200);
        $response->assertViewIs('pokemon.show');
    }

    /**
     * 5. GET /pokemon/nombreinvalido responde de forma controlada.
     */
    public function test_pokemon_invalido_muestra_vista_error(): void
    {
        Http::fake([
            'pokeapi.co/api/v2/pokemon/nombreinvalido' => Http::response(null, 404),
        ]);

        $response = $this->actingAs($this->user)->get('/pokemon/nombreinvalido');

        $response->assertStatus(200);
        $response->assertViewIs('pokemon.error');
    }

    /**
     * 6. Buscador vacío en /pokemon muestra validación.
     */
    public function test_buscador_vacio_muestra_error_de_validacion(): void
    {
        Http::fake([
            'pokeapi.co/api/v2/pokemon*' => Http::response(['results' => []], 200),
        ]);

        $response = $this->actingAs($this->user)->get('/pokemon?search=');

        $response->assertStatus(200);
        
        // Obtenemos los errores de la vista y verificamos que exista el de 'search'
        $errors = $response->viewData('errors');
        $this->assertTrue($errors->has('search'));
    }
}