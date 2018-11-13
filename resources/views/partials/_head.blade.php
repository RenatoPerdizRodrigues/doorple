<!-- Partial da head do documento, que permite que uma sessão de CSS seja adicionada por página -->

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
    @yield('css')
    <title>Doorple @yield('title')</title>