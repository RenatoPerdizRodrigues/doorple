@extends('main')

@section('title', '| Deletar Veículo')

@section('content')
<h3>Deseja deletar {{$veiculo_morador->license_plate}} de {{$veiculo_morador->morador->name}}?</h3>
    <form method="POST" action="{{ route('veiculo_morador.destroy', $veiculo_morador->id) }}">
        @csrf
        <input hidden type="text" name="_method" value="DELETE">
        <input type="submit" value="Sim">
    </form>
    <a href="{{route('admin.dashboard')}}">Não</a>
@stop