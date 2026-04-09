<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PokemonCapturado extends Model
{
    protected $table = 'pokemon_capturados';
    protected $fillable = ['user_id', 'nombre', 'imagen_url', 'hp', 'attack', 'defense', 'tipos', 'sonido_url'];
}