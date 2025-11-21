<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
</head>

<body>
    <h1>Conexion a Base de Datos Postgresql</h1>

    <h1>Lista de Productos</h1>
    <h4>Lista de Productos</h4>
    <ul>
        @foreach ($productos as $producto)
            <li>{{ $producto->nombre }} - {{ $producto->costo }} - {{ $producto->stock }}</li>
        @endforeach
    </ul>

    <h4>Lista de Clientes</h4>
    <ul>
        @foreach ($clientes as $cliente)
            <li>{{ $cliente->nombre }} - {{ $cliente->email }} - {{ $cliente->telefono }}</li>
        @endforeach
    </ul>


    <h3>Primer commit o cambio desde otro dispositivo</h3>

    <h2>segondo cambio Rafa esta pendejo</h2>

    <h1>rodrigo vista 2 aaaaaaaaaaaaaaaaaaaaaaaa</h1>


    <h1>rodrigo view1</h1>

</body>

</html>
