<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\PokemonCapturado;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CruzPokemonTest extends TestCase
{
    use RefreshDatabase;

    // Autor: Juan Carlos Cruz Hernández
    public function test_guardar_pokemon_en_db_local()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/pokemon/guardar', [
            'nombre' => 'ditto', 'imagen_url' => 'd.png', 'hp' => 48, 'attack' => 48, 'defense' => 48, 'tipos' => 'normal', 'sonido_url' => 's.mp3'
        ]);
        $this->assertDatabaseHas('pokemon_capturados', ['nombre' => 'ditto', 'user_id' => $user->id]);
    }

    // Autor: Juan Carlos Cruz Hernández
    public function test_ver_mi_equipo_local()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/mi-equipo');
        $response->assertStatus(200);
    }

    // Autor: Juan Carlos Cruz Hernández
    public function test_no_ver_equipo_sin_login()
    {
        $response = $this->get('/mi-equipo');
        $response->assertRedirect('/mi-login');
    }

    // Autor: Juan Carlos Cruz Hernández
    public function test_cerrar_sesion_usuario()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/logout');
        $this->assertGuest();
    }

    // Autor: Juan Carlos Cruz Hernández
    public function test_eliminar_pokemon_de_db()
    {
        $user = User::factory()->create();
        $pokemon = PokemonCapturado::create(['user_id' => $user->id, 'nombre' => 'pidgey', 'hp' => 10, 'attack' => 10, 'defense' => 10, 'tipos' => 'fly', 'imagen_url' => 'p.png', 'sonido_url' => 's.mp3']);
        $response = $this->actingAs($user)->delete("/mi-equipo/{$pokemon->id}");
        $this->assertDatabaseMissing('pokemon_capturados', ['id' => $pokemon->id]);
    }

    // Autor: Juan Carlos Cruz Hernández
    public function test_ver_detalle_pokemon_local()
    {
        $user = User::factory()->create();
        $pokemon = PokemonCapturado::create(['user_id' => $user->id, 'nombre' => 'eevee', 'hp' => 55, 'attack' => 55, 'defense' => 50, 'tipos' => 'normal', 'imagen_url' => 'e.png', 'sonido_url' => 's.mp3']);
        $response = $this->actingAs($user)->get("/mi-equipo/{$pokemon->id}");
        $response->assertSee('EEVEE');
    }

    // Autor: Juan Carlos Cruz Hernández
    public function test_validar_nombre_obligatorio_al_guardar()
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/pokemon/guardar', ['hp' => 50]);
        $this->assertDatabaseCount('pokemon_capturados', 0);
    }

    // Autor: Juan Carlos Cruz Hernández
    public function test_cargar_vista_login()
    {
        $response = $this->get('/mi-login');
        $response->assertOk();
    }

    // Autor: Juan Carlos Cruz Hernández
    public function test_cargar_vista_registro()
    {
        $response = $this->get('/registro');
        $response->assertOk();
    }

    // Autor: Cruz
    public function test_segundo_request_no_llama_a_http()
    {
        $user = \App\Models\User::factory()->create();
        $fakeData = ['name' => 'pikachu', 'id' => 25, 'sprites' => ['front_default' => ''], 'types' => [['type' => ['name' => 'e']]], 'stats' => []];
        
        // 1. Guardamos datos en el caché manualmente
        Cache::put('pokemon_detail_pikachu', $fakeData, 300);

        // 2. Registramos el fake pero con una respuesta que falle 
        // para asegurar que si el test pasa, es porque leyó del caché y NO de la API
        Http::fake(['pokeapi.co/*' => Http::response(null, 500)]);

        $response = $this->actingAs($user)->get('/pokemon/pikachu');

        // Si responde 200 y vemos a pikachu, es que usó el caché
        $response->assertStatus(200);
        $response->assertSee('pikachu');
    }
}