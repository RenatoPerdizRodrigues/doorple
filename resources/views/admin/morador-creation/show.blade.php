@extends('main')

@section('title', '| Visualização de Morador')

@section('content')
    <img src="{{"/images/morador/".$morador->picture}}">
    <h3>Nome: {{$morador->name . " " . $morador->surname}}</h3>
    <h4>RG: {{$morador->rg}}</h4>
    <h4>Apartamento: {{$morador->bloco->prefix . "-" . $morador->apartamento->apartamento}}</h4>
    <a href="{{route('morador.edit', $morador->id)}}">Editar</a>
    <a href="{{route('morador.delete', $morador->id)}}">Excluir</a><br><br>

    <h2>Registro de Entradas</h2>
    @foreach($entradas as $entrada)
        Data: {{$entrada->created_at}}
    @endforeach
@stop