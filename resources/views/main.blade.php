<!-- Todo o conteúdo das views será mostrado nesta página -->

<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials/_head')
</head>
<body>
    <div class="wrapper">
        @yield('content')
    </div>
    <a href="{{route('main')}}">Voltar à página inicial</a>
</body>
</html>