<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Muestra el formulario HTML
    public function index()
    {
        return view('registro');
    }

    // Procesa los datos y crea el usuario
    public function store(Request $request)
    {
        // 1. Validar que todo esté correcto y el correo no exista ya
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        // 2. Crear al usuario en la base de datos (encriptando la contraseña)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 3. Iniciar sesión automáticamente con el nuevo usuario
        Auth::login($user);

        // 4. Mandarlo al Home
        return redirect('/');
    }
}