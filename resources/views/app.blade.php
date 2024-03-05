<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width" />
    <link rel="icon" href="{{ asset('images/favicon-32x32.png') }}">

    @vite('resources/js/app.js')
</head>
<body class="antialiased font-sans">
    <div id="app"></div>
</body>
</html>
