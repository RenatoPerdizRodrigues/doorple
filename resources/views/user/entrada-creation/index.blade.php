@extends('main')

@section('title', '| Index de Visitas')

@section('content')
<h3>Procure uma entrada através do dia, mês e ano</h3>
    <form method="POST" action="{{ route('entrada.search.submit') }}">
        @csrf
        <label>Dia da Entrada</label>
        <input type="date" name="date"><br>
        <input type="submit" value="Procurar">
    </form><br><br>

    @if(empty($entradas[0]))
        Não há entradas registradas para este dia
    @else

    <h2>Entradas do Dia </h2>
    @foreach($entradas as $entrada)
        Morador: {{$entrada->morador->name . ' ' . $entrada->morador->surname}} | Apartamento: {{$entrada->morador->bloco->prefix . '-' . $entrada->morador->apartamento->apartamento}} | Horário: {{$entrada->created_at}}<br> 
    @endforeach
    
    @endif
@stop