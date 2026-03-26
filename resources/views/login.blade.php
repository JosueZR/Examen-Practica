<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POKEFLEX</title>
    
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>
<body>

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

            @error('email')
                <p class="error-msg">{{ $message }}</p>
            @enderror
        </form>
    </div>

</body>
</html>