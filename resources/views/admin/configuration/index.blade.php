@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
<h3>Visualização de Apartamentos</h3>
<form method="POST" action="{{ route('admin.config.search.submit') }}">
        @csrf
        <label>Apartamento: </label>
        <input type="text" name="apartamento"><br>
        <input type="submit" value="Procurar">
    </form><br><br>
    @foreach($apartamentos as $apartamento)
        <p>Apartamento: {{$apartamento->apartamento}}</p>
        <p>Moradores: </p>
        @if(count($apartamento->moradores) == 0)
            <p>Apartamento Vazio</p>
        @else
            <ul>
            @foreach($apartamento->moradores as $morador)
                <li><a href="{{route('morador.show', $morador->id)}}">{{$morador->name . " " . $morador->surname}}</a></li>
            @endforeach
            </ul>
        @endif
    @endforeach
@stop