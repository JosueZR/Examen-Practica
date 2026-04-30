<?php

namespace Tests\Unit;

use Tests\TestCase; // <-- ¡Asegúrate de que sea este TestCase y no el de PHPUnit!
use App\Services\PokemonMapper;
use App\Services\PokeApiService;
use Illuminate\Support\Facades\Http;

class PokemonLogicTest extends TestCase
{
    protected PokemonMapper $mapper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mapper = new PokemonMapper();
    }

    /**
     * 1. El mapper devuelve un arreglo con las llaves esperadas.
     */
    public function test_mapper_devuelve_llaves_esperadas(): void
    {
        $apiData = ['id' => 1, 'name' => 'bulbasaur'];
        $result = $this->mapper->map($apiData);

        $this->assertArrayHasKey('id', $result);
        $this->assertArrayHasKey('name', $result);
        $this->assertArrayHasKey('sprite', $result);
        $this->assertArrayHasKey('image', $result);
        $this->assertArrayHasKey('cry', $result);
        $this->assertArrayHasKey('types', $result);
        $this->assertArrayHasKey('hp', $result);
        $this->assertArrayHasKey('attack', $result);
        $this->assertArrayHasKey('defense', $result);
    }

    /**
     * 2. Extrae tipos correctamente cuando hay 1 tipo.
     */
    public function test_extrae_un_tipo_correctamente(): void
    {
        $apiData = [
            'types' => [
                ['type' => ['name' => 'water']]
            ]
        ];
        
        $result = $this->mapper->map($apiData);

        $this->assertCount(1, $result['types']);
        $this->assertEquals('water', $result['types'][0]);
    }

    /**
     * 3. Extrae tipos correctamente cuando hay 2 tipos.
     */
    public function test_extrae_dos_tipos_correctamente(): void
    {
        $apiData = [
            'types' => [
                ['type' => ['name' => 'grass']],
                ['type' => ['name' => 'poison']]
            ]
        ];
        
        $result = $this->mapper->map($apiData);

        $this->assertCount(2, $result['types']);
        $this->assertEquals('grass', $result['types'][0]);
        $this->assertEquals('poison', $result['types'][1]);
    }

    /**
     * 4. Extrae stats hp/attack/defense correctamente.
     */
    public function test_extrae_stats_correctamente(): void
    {
        $apiData = [
            'stats' => [
                ['stat' => ['name' => 'hp'], 'base_stat' => 45],
                ['stat' => ['name' => 'attack'], 'base_stat' => 49],
                ['stat' => ['name' => 'defense'], 'base_stat' => 49],
                ['stat' => ['name' => 'speed'], 'base_stat' => 45], // Stat extra para probar que lo ignora
            ]
        ];
        
        $result = $this->mapper->map($apiData);

        $this->assertEquals(45, $result['hp']);
        $this->assertEquals(49, $result['attack']);
        $this->assertEquals(49, $result['defense']);
    }

    /**
     * 5. Maneja respuesta incompleta (faltan campos) sin romper.
     */
    public function test_maneja_respuesta_incompleta(): void
    {
        // Solo mandamos el nombre, sin stats ni types ni sprites
        $apiData = ['name' => 'mew'];
        $result = $this->mapper->map($apiData);

        $this->assertEquals('mew', $result['name']);
        $this->assertEmpty($result['types']);
        $this->assertEquals(0, $result['hp']);
        $this->assertNull($result['sprite']);
    }

    /**
     * 6. Maneja respuesta vacía sin romper.
     */
    public function test_maneja_respuesta_vacia(): void
    {
        $apiData = [];
        $result = $this->mapper->map($apiData);

        $this->assertEquals('Unknown', $result['name']);
        $this->assertEquals(0, $result['id']);
        $this->assertEquals(0, $result['attack']);
    }

    /**
     * 7. Normalización de nombre (trim/lower).
     */
    public function test_normalizacion_de_nombre(): void
    {
        // Pasamos un nombre con mayúsculas y espacios en blanco
        $apiData = ['name' => '  PiKaChU  '];
        $result = $this->mapper->map($apiData);

        $this->assertEquals('pikachu', $result['name']);
    }

    /**
     * 8. Manejo de “pokemon no encontrado” (respuesta 404) de forma controlada.
     */
    public function test_pokemon_no_encontrado_404(): void
    {
        // Simulamos que el API devuelve un error 404
        Http::fake([
            'pokeapi.co/api/v2/pokemon/missingno' => Http::response(null, 404),
        ]);

        $service = new PokeApiService();
        $result = $service->getPokemon('missingno');

        // Según nuestra lógica del servicio, si no es exitoso (ej. 404), devuelve null
        $this->assertNull($result);
    }
}