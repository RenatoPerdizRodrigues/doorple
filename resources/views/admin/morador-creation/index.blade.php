@extends('main')

@section('title', '| Index de Morador')

@section('content')
<h3>Encontre um Usuário</h3>
    <form method="POST" action="{{ route('morador.search.submit') }}">
        @csrf
        <label>RG do Morador</label>
        <input type="text" name="rg"><br>
        <input type="submit" value="Procurar">
    </form><br><br>
    @foreach($moradores as $morador)
        <p>{{$morador->name . " ". $morador->surname . "|" . $morador->apartamento->apartamento}}</p>
        <p><a href="{{route('morador.show', $morador->id)}}">Visualizar</a></p>
    @endforeach
@stop