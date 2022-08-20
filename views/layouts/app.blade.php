<!DOCTYPE html>
<html lang="{{ config('app.lang', 'en') }}" data-theme="dark">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name', 'PHPLite') }}</title>

        <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">
    </head>
    <body class="container">
        @yield('content')

        <footer class="container">
            <small>Frontend with <a href="https://picocss.com">Pico.css</a></small>
        </footer>
    </body>
</html>