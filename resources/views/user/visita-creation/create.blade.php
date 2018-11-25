@extends('main')

@section('title', '| Cadastro de Usuário')

@section('content')
<h3>Dados da Visita</h3>
    <form method="POST" action="{{ route('visita.store') }}">
        @csrf
        <h2>Visitante</h2>
        <!-- Visitante -->
        <label>Nome</label>
        <input type="text" name="name" disabled value="{{$visitante->name}}"><br>
        <label>Sobrenome</label>
        <input type="text" name="surname" disabled value="{{$visitante->surname}}"><br>
        <input hidden name="visitante_id" value="{{$visitante->id}}">

        <!-- Apartamento a ser visitado -->
        <h2>Apartamento a ser Visitado</h2>
        <label>Bloco</label>
        <input name="blocoview" disabled value="{{$bloco->prefix}}"><br>
        <input name="bloco" hidden value="{{$bloco->id}}"><br>
        <label>Apartamento</label>
        <input name="apartamentoview" disabled value="{{$apartamento->apartamento}}">
        <input name="apartamento" hidden value="{{$apartamento->id}}">

        <!-- Carro -->
        <h2>Carro</h2>
        <label>Modelo do Veículo</label>
        <input type="text" name="vehicle_model" value="{{$modelo}}"><br>
        <label>Placa do Veículo</label>
        <input type="text" name="vehicle_license_plate" value="{{$placa}}"><br><br>
        <input type="submit" value="Cadastrar visita">
    </form>
@stop