@extends('main')

@section('title', '| Cadastro de Usuário')

@section('content')
<h3>Cadastre um novo Usuário</h3>
    <form method="POST" enctype="multipart/form-data" action="{{ route('vst.store') }}">
        @csrf
        <!-- Visitante -->
        <label>Nome</label>
        <input type="text" name="name"><br>
        <label>Sobrenome</label>
        <input type="text" name="surname"><br>
        <label>RG</label>
        <input type="text" name="rg" value="{{$rg}}"><br>
        <label>Data de Nascimento</label>
        <input type="date" name="birthdate"><br>
        <label>Foto</label>
        <input type="file" name="picture"><br>

        <!-- Apartamento a ser visitado -->
        <h3>Apartamento a ser Visitado</h3>
        <label>Bloco</label>
        <select name="bloco">
            @foreach($blocos as $bloco)
                <option value="{{$bloco->id}}" @if($blocovisita == $bloco->id) selected @endif>{{$bloco->prefix}}</option>
            @endforeach
        </select>
        <label>Apartamento</label>
        <select name="apartamento">
            @foreach($bloco->apartamentos as $apartamento)
                    <option value="{{$apartamento->id}}" @if($apartamentovisita == $apartamento->apartamento) selected @endif>{{$apartamento->apartamento}}</option>
            @endforeach
        </select><br><br>

        <!-- Carro -->
        <h3>Visitante está visitando de carro?</h3>
        <label>Modelo do Veículo</label>
        <input type="text" name="vehicle_model"><br>
        <label>Placa do Veículo</label>
        <input type="text" name="vehicle_license_plate"><br><br>
        <input type="submit" value="Continuar visita">
    </form>
@stop