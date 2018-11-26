@extends('main')

@section('title', '| Visualização de Visitante')

@section('content')
    <img src="{{"/images/visitante/".$visitante->picture}}"><br>
    Nome: {{$visitante->name}}<br>
    Sobrenome: {{$visitante->surname}}<br>
    RG: {{$visitante->rg}}<br><br>

    <a href="{{route('vst.edit', $visitante->id)}}">Editar</a>  <a href="{{route('vst.delete', $visitante->id)}}">Excluir</a><br>

    <br>Visitas:<br>
    @foreach($visitante->visitas as $visita)
        Apartamento {{$visita->bloco->prefix . '-' . $visita->apartamento->apartamento}}
    @endforeach
@stop