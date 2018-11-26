@extends('main')

@section('title', '| Cadastro de Usuário')

@section('content')
<h3>Cadastre um novo Usuário</h3>
    <form method="POST" enctype="multipart/form-data" action="{{ route('vst.update', $visitante->id) }}">
        @csrf
        <!-- Visitante -->
        <label>Nome</label>
        <input type="text" name="name" value="{{$visitante->name}}"><br>
        <label>Sobrenome</label>
        <input type="text" name="surname" value="{{$visitante->surname}}"><br>
        <label>RG</label>
        <input type="text" name="rg" value="{{$visitante->rg}}"><br>
        <label>Data de Nascimento</label>
        <input type="date" name="birthdate" value="{{$visitante->birthdate}}"><br>
        <label>Foto</label>
        <input type="file" name="picture"><br>
        <input type="submit" value="Cadastrar">

        <!-- Carro -->
        <h3>Último carro cadastrado?</h3>
        <label>Modelo do Veículo</label>
        <input type="text" name="vehicle_model" value="{{$visitante->vehicle_model ? $visitante->vehicle_model : "" }}"><br>
        <label>Placa do Veículo</label>
        <input type="text" name="vehicle_license_plate" value="{{$visitante->vehicle_license_plate ? $visitante->vehicle_license_plate : "" }}"<br><br>
        <input type="submit" value="Continuar visita">

        <input hidden name="_method" value="PUT">
    </form>
@stop