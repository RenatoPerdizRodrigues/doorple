@extends('main')

@section('title', '| Encontre um Visitante')

@section('content')

<h1>Digite o RG do visitante</h1>
<form method="POST" action="{{ route('vst.search.submit') }}">
    @csrf
    <label>RG: </label>
    <input type="text" name="rg"><br>
    <input type="submit" value="Buscar">
</form><br><br>

@stop