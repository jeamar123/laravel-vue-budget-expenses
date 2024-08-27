<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-114115155-1"></script>
    <script>
      window.dataLayer = window.dataLayer || []
      function gtag() {
        dataLayer.push(arguments)
      }
      gtag('js', new Date())

      gtag('config', 'UA-114115155-1')
    </script>

    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, width=device-width" />
    <link rel="icon" href="{{ asset('images/jl-logo-black.png') }}">
    <title>Budget Expenses - Jmardev</title>

    @vite('resources/js/app.js')
</head>
<body class="antialiased font-sans">
    <div id="app"></div>
</body>
</html>
