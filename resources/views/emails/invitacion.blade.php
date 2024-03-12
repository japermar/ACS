<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ahora eres miembro de {{ $nombre }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            padding: 20px;
            background-color: #ffffff;
            margin: 20px auto;
            max-width: 600px;
            border-radius: 5px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 10px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.8em;
            color: #6c757d;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Bienvenido a {{ $nombre }}</h1>
    </div>
    <div class="content">
        <p>Este mensaje es para notificarte que ahora eres miembro del grupo <strong>{{ $nombre }}</strong> en ACS.</p>
    </div>
    <div class="footer">
        © {{ date('Y') }} {{ $nombre }}. Todos los derechos reservados.
    </div>
</div>
</body>
</html>
