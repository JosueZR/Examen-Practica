<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Esta función solo muestra el formulario HTML
    public function index()
    {
        return view('login'); 
    }

    // Esta función procesa los datos cuando el usuario hace clic en "Entrar"
    public function authenticate(Request $request)
    {
        // 1. Validar que no envíen campos vacíos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Auth::attempt va a tu SQLite y revisa si el correo y la contraseña coinciden
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Si todo está bien, lo mandamos a una página de bienvenida
            return redirect()->intended('dashboard'); 
        }

        // 3. Si se equivoca de contraseña o correo, lo regresamos con un error
        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ]);
    }
}