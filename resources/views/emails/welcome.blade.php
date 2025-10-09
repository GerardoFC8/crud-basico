<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { padding: 20px; border: 1px solid #ddd; border-radius: 8px; }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #FF2D20;
            color: #fff !important;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>¡Hola, {{ $user->name }}!</h1>
        <p>Te damos la bienvenida a nuestra increíble aplicación. Estamos muy contentos de tenerte con nosotros.</p>
        <img src="{{ $message->embed(public_path('vendor/adminlte/dist/img/AdminLTELogo.png')) }}" alt="Bienvenido" style="max-width: 100%; height: auto; margin: 20px 0;">
        <p>Para empezar, te invitamos a explorar tu nuevo panel de control:</p>
        <a href="{{ url('/dashboard') }}" class="button">Ir al Dashboard</a>
        <p style="margin-top: 20px;">Saludos,<br>El equipo de {{ config('app.name') }}</p>
    </div>
</body>
</html>
