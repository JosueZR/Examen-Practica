<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POKEFLEX</title>
    
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body class="pantalla-login">

    <img src="{{ asset('images/pokemon1.gif') }}" class="poke-fondo-1" alt="Pokemon 1">
    <img src="{{ asset('images/pokemon2.gif') }}" class="poke-fondo-2" alt="Pokemon 2">

    <div class="login-container">
        <h2>Iniciar Sesión</h2>

        <form method="POST" action="/mi-login">
            @csrf
            
            <div class="form-group">
                <label>Correo Electrónico</label>
                <input type="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn-entrar">Entrar</button>
            
            <div style="text-align: center; margin-top: 15px;">
                <a href="/registro" style="color: white; text-decoration: none; font-size: 0.9em;">¿No tienes cuenta? Regístrate aquí</a>
            </div>

            @error('email')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </form>
    </div>

</body>
</html>