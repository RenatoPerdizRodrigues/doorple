@extends('main')

@section('title', '| Cadastro de Veículo')

@section('content')
<h3>Cadastre um novo Veículo para {{$morador->name}}</h3>
    <form method="POST"  action="{{ route('veiculo_morador.store') }}">
        @csrf
        <select name="type">
            <option value="carro">Carro</option>
            <option value="moto">Moto</option>
        </select>
        <label>Placa</label>
        <input type="text" name="license_plate"><br>
        <label>Cor</label>
        <input type="text" name="color"><br>
        <p>Dono: {{ $morador->name . " " . $morador->surname }}</p>
        <input hidden name="morador_id" value="{{$morador->id}}">
        <input type="submit" value="Cadastrar">
    </form>
@stop