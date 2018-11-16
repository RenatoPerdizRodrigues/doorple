@extends('main')

@section('title', '| Edição de Veículo')

@section('content')
<h3>Edição de Veículo</h3>
<form method="POST"  action="{{ route('veiculo_morador.update', $veiculo_morador->id) }}">
        @csrf
        <select name="type">
            <option @if($veiculo_morador->type == "carro") selected @endif value="carro">Carro</option>
            <option @if($veiculo_morador->type == "moto") selected @endif value="moto">Moto</option>
        </select>
        <label>Placa</label>
        <input type="text" name="license_plate" value="{{$veiculo_morador->license_plate}}"><br>
        <label>Cor</label>
        <input type="text" name="color" value="{{$veiculo_morador->color}}"><br>
        <input hidden name="morador_id" value="{{$veiculo_morador->morador_id}}">
        <input hidden name="_method" value="PUT">
        <input type="submit" value="Cadastrar">
    </form>
@stop