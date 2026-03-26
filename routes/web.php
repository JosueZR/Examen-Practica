<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController; // Tu controlador hasta arriba

Route::get('/', function () {
    return redirect('/mi-login'); // Esto te mandará directo a tu formulario
});

// ---------------------------------------------------
// RUTAS DEL LOGIN
// ---------------------------------------------------
Route::get('/mi-login', [LoginController::class, 'index'])->name('login');
Route::post('/mi-login', [LoginController::class, 'authenticate']);

// Tu propio Dashboard de prueba
Route::get('/dashboard', function () {
    return '¡Éxito! Estás dentro de tu propio sistema.';
})->middleware('auth');

// ---------------------------------------------------
// RUTAS DEL PERFIL 
// ---------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
