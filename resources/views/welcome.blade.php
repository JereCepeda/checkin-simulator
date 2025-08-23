<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        
    </head>
    <body class="antialiased">
        <h1>Bienvenido a Andes Airlines CHECKIN</h1>
        <form action="{{ route('buscar.vuelo') }}" method="GET">
            @csrf
            <div>
                <h1>Ingrese el ID de su Vuelo</h1>
                <input type="number" name="flight_id" required>
                <button type="submit">Buscar Vuelo</button>
            </div>
        </form>
    </body>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f3f4f6;
            color: #111827;
            margin: 0;
            padding: 20px;
        }
        div {
            max-width: 400px;
            margin: 0 auto;
            text-align: center;
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        input[type="number"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #d1d5db;
            border-radius: 4px;
        }
        button {
            background-color: blue;
            color: white;
            padding: 10px 15px;
            border-radius: 4px;
          
        }
        button:hover {
            background-color: green;
        }
        
    </style>
</html>
