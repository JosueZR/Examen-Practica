<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POKÉDEX - Registro</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}?v={{ time() }}">
</head>

<body class="pantalla-login">

    <img src="{{ asset('images/pokemon1.gif') }}" class="poke-fondo-1" alt="Pokemon 1">
    <img src="{{ asset('images/pokemon2.gif') }}" class="poke-fondo-2" alt="Pokemon 2">

    <div class="login-container">
        <h2>Crear Cuenta</h2>

        <form method="POST" action="/registro">
            @csrf
            
            <div class="form-group">
                <label>Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus>
                @error('name') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <p class="error-msg">{{ $message }}</p> @enderror
            </div>
            
            <div class="form-group">
                <label>Contraseña (mín. 8 caracteres)</label>
                <input type="password" name="password" required>
                @error('password') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="btn-entrar">Registrarse</button>

            <div style="text-align: center; margin-top: 15px;">
                <a href="/mi-login" style="color: white; text-decoration: none; font-size: 0.9em; font-family: 'Quicksand', sans-serif; font-weight: bold;">
                    ¿Ya tienes cuenta? Inicia sesión
                </a>
            </div>
        </form>
    </div>

</body>
</html>