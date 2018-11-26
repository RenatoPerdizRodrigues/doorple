@extends('main')

@section('title', '| Confirmação de Entrada')

@section('content')
<h3>Registro de entrada de morador</h3>
    <form method="POST" action="{{ route('entrada.store') }}">
        @csrf
        <!-- Visitante -->
        <p>Morador {{$morador->name . ' ' . $morador->surname}}, do apartamento {{$morador->bloco->prefix . '-' . $morador->apartamento->apartamento }}, está entrando com algum veículo?

        <select name="veiculo_id">
            <option value="">Nenhum</option>
            @foreach($morador->veiculos as $veiculo)
                <option value={{$veiculo->id}}>{{$veiculo->type . ' ' . $veiculo->license_plate}}</option>
            @endforeach
        </select>
        <input hidden type="text" name="morador_id" value="{{$morador->id}}"><br>
        <input type="submit" value="Confirmar">
    </form>
@stop