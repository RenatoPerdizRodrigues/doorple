@extends('main')

@section('title', '| Index de Visitas')

@section('content')
<h3>Procure uma visita através do dia, mês e ano</h3>
    <form method="POST" action="{{ route('visita.search.submit') }}">
        @csrf
        <label>Dia da Visita</label>
        <input type="date" name="date"><br>
        <input type="submit" value="Procurar">
    </form><br><br>

    @if(empty($visitas[0]))
        Não há visitas registradas para este dia
    @else

    <h2>Visitas do dia </h2>
    @foreach($visitas as $visita)
        Visitante: {{$visita->visitante->name . ' ' . $visita->visitante->surname}} | Apartamento: {{$visita->bloco->prefix . '-' . $visita->apartamento->apartamento}} | Veículo: {{$visita->vehicle_model . ' de placa ' . $visita->vehicle_license_plate}} | Data da visita: {{$visita->created_at}}<br>
    @endforeach
    
    @endif
@stop