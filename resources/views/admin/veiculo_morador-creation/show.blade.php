@extends('main')

@section('title', '| Visualização de Morador')

@section('content')
    <h3>Placa: {{$veiculo_morador->license_plate}}</h3>
    <h4>Cor: {{$veiculo_morador->color}}</h4>
    <h4>Dono: {{$veiculo_morador->morador->name}}</h4>
    <a href="{{route('veiculo_morador.edit', $veiculo_morador->id)}}">Editar</a>
    <a href="{{route('veiculo_morador.delete', $veiculo_morador->id)}}">Excluir</a>
@stop