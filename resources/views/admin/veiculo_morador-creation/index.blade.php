@extends('main')

@section('title', '| Index de Veículo')

@section('content')
<h3>Encontre um Usuário</h3>
    <form method="POST" action="{{ route('veiculo_morador.search.submit') }}">
        @csrf
        <label>Placa do Motorista</label>
        <input type="text" name="license_plate"><br>
        <input type="submit" value="Procurar">
    </form><br><br>
    @foreach($veiculos_morador as $veiculo)
        <p>{{$veiculo->license_plate . " | " . $veiculo->morador->name . " do " . $veiculo->morador->apartamento->apartamento}}</p>
        <p><a href="{{route('veiculo_morador.show', $veiculo->id)}}">Visualizar</a></p>
    @endforeach
@stop