@extends('main')

@section('title', '| Index de Visitante')

@section('content')
<h3>Encontre um Visitante</h3>
    <form method="POST" action="{{ route('vst.find.submit') }}">
        @csrf
        <label>RG do Visitante</label>
        <input type="text" name="rg"><br>
        <input type="submit" value="Procurar">
    </form><br><br>

    @foreach($visitantes as $visitante)
Nome: {{$visitante->name . ' ' . $visitante->surname}} | RG: {{$visitante->rg}} | <a href="{{route('vst.show', $visitante->id)}}">Visualizar</a>
    @endforeach
@stop