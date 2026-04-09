<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\PokemonController; 
use App\Http\Controllers\RegisterController;

// ---------------------------------------------------
// RUTAS DEL LOGIN (Se quedan igual)
// ---------------------------------------------------
Route::get('/mi-login', [LoginController::class, 'index'])->name('login');
Route::post('/mi-login', [LoginController::class, 'authenticate']);
Route::get('/registro', [RegisterController::class, 'index']);
Route::post('/registro', [RegisterController::class, 'store']);

// ---------------------------------------------------
// RUTA DEL HOME (Protegida)
// ---------------------------------------------------
// Esta es la ruta "/", pero el middleware obliga a pasar por el login primero.
Route::get('/', function () {
    return view('home'); 
})->middleware('auth');

// ---------------------------------------------------
// RUTAS DEL PERFIL 
// ---------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/pokemon', [PokemonController::class, 'index']);
    Route::get('/pokemon/{name}', [PokemonController::class, 'show']);
    Route::get('/about', function () {
        return view('about');
    });
    // Ruta para ver el detalle de un Pokémon guardado en la base de datos
    Route::get('/mi-equipo/{id}', [PokemonController::class, 'showLocal']);

    // Rutas para la base de datos local (Offline)
    Route::post('/pokemon/guardar', [PokemonController::class, 'guardarLocal']);
    Route::get('/mi-equipo', [PokemonController::class, 'verEquipo']);
    Route::get('/mi-equipo/{id}', [PokemonController::class, 'showLocal']);
    Route::delete('/mi-equipo/{id}', [PokemonController::class, 'eliminarLocal']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});