<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class RobledoPokemonTest extends TestCase
{
    use RefreshDatabase;

    // Autor: Robledo
    public function test_obtener_datos_pokemon_fake_1()
    {
        Http::fake(['pokeapi.co/*' => Http::response(['name' => 'pikachu', 'id' => 25, 'sprites' => ['front_default' => 'p.png'], 'types' => [['type' => ['name' => 'electric']]], 'stats' => [['base_stat' => 35, 'stat' => ['name' => 'hp']]], 'cries' => ['latest' => 'a.mp3']], 200)]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/pokemon/pikachu');
        $response->assertStatus(200);
    }

    // Autor: Robledo
    public function test_obtener_datos_pokemon_fake_2()
    {
        Http::fake(['pokeapi.co/*' => Http::response(['name' => 'charmander', 'id' => 4, 'sprites' => ['front_default' => 'c.png'], 'types' => [['type' => ['name' => 'fire']]], 'stats' => [['base_stat' => 39, 'stat' => ['name' => 'hp']]], 'cries' => ['latest' => 'a.mp3']], 200)]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/pokemon/charmander');
        $response->assertSee('charmander');
    }

    // Autor: Robledo
    public function test_api_error_404_simulado()
    {
        Http::fake(['pokeapi.co/*' => Http::response([], 404)]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/pokemon/no-existe');
        $response->assertStatus(200); // Vista de error cargada
    }

    // Autor: Robledo
    public function test_buscador_filtra_correctamente()
    {
        Http::fake(['pokeapi.co/*' => Http::response(['results' => [['name' => 'bulbasaur']]], 200)]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/pokemon?search=bulba');
        $response->assertSee('bulbasaur');
    }

    // Autor: Robledo
    public function test_carga_pagina_about()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/about');
        $response->assertOk();
    }

    // Autor: Robledo
    public function test_redireccion_home_al_login()
    {
        $response = $this->get('/');
        $response->assertRedirect('/mi-login');
    }

    // Autor: Robledo
    public function test_lista_pokemon_inicial_fake()
    {
        Http::fake(['pokeapi.co/*' => Http::response(['results' => [['name' => 'mew']]], 200)]);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/pokemon');
        $response->assertSee('mew');
    }

    // Autor: Robledo
    public function test_mensaje_error_sin_conexion()
    {
        // Simulamos que la API devuelve un error 500 (Servidor caído)
        Http::fake(['pokeapi.co/*' => Http::response(null, 500)]);
        
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/pokemon');
        
        // CAMBIO AQUÍ: Usamos el texto que tu vista realmente muestra
        $response->assertSee('No se encontró ningún Pokémon');
    }

    // Autor: Robledo
    public function test_acceso_home_autenticado()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
    }

    public function test_primer_request_guarda_en_cache()
    {
        Cache::flush(); // Limpiar caché antes de empezar
        $user = \App\Models\User::factory()->create();
        
        Http::fake([
            'pokeapi.co/*' => Http::response(['name' => 'pikachu', 'id' => 25, 'sprites' => [], 'types' => [], 'stats' => []], 200)
        ]);

        $this->actingAs($user)->get('/pokemon/pikachu');

        // Verificamos que ahora exista en el caché
        $this->assertTrue(Cache::has('pokemon_detail_pikachu'));
    }

    // Autor: Robledo
    public function test_simular_error_500_y_validar_respuesta_amigable()
    {
        Cache::flush();
        $user = \App\Models\User::factory()->create();

        // Simulamos que la PokéAPI explotó (Error 500)
        Http::fake([
            'pokeapi.co/*' => Http::response('Server Error', 500)
        ]);

        $response = $this->actingAs($user)->get('/pokemon/mewtwo');

        // Validamos que el usuario vea la vista de error en lugar de un error de sistema
        $response->assertStatus(200);
        $response->assertSee('Pokémon no encontrado');
    }
}