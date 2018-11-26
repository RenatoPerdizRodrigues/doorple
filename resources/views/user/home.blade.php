<!-- Pàgina principal de usuário, a ser construída -->
<!-- Nesta página, o Javascript se prepara para soltar uma notificação de acordo com a quatnidade de tempo restante para o carro no condomínio -->
<?php
    //Quantidade de segundos de espera antes que a notificação seja enviada
    $milisegundos = ($configs[0]->car_time * 60) * 1000;
?>

@extends('main')

@section('title', '| Página Principal de Usuário')

@section('js')
@stop

@section('content')
    <h3>Bem-vindo, administrador</h3>
    @if(Auth::guard('web')->check())
        <p>Usuário está logado</p>
    @else
        <p>Usuário não está logado</p>
    @endif

    <a href="{{route('vst.main')}}">Nova Visita</a><br>
    <a href="{{route('visita.index')}}">Buscar Visitas</a><br>
    <a href="{{route('vst.index')}}">Buscar Visitantes</a><br><br>
    <a href="{{route('entrada.create')}}">Nova Entrada de Morador</a><br>
    <a href="{{route('entrada.index')}}">Buscar Entradas</a><br>
    

    <h2>Carros de visitantes no condomínio</h2>
    @foreach($carros as $carro)    
        Visitante: {{$carro->visitante->name . ' ' . $carro->visitante->surname}} | Apartamento {{$carro->bloco->prefix . '-' . $carro->apartamento->apartamento}} | @if($carro->vehicle_license_plate && $carro->vehicle_model) {{$carro->vehicle_model . ' - ' . $carro->vehicle_license_plate}} @endif Horário de entrada: {{$carro->created_at}} <br>
    @endforeach<br>
    <h2>Visitas do Dia</h2>
    @foreach($visitas as $visita)    
        Visitante: {{$visita->visitante->name . ' ' . $visita->visitante->surname}} | Apartamento {{$visita->bloco->prefix . '-' . $visita->apartamento->apartamento}} | @if($visita->vehicle_license_plate && $visita->vehicle_model) {{$visita->vehicle_model . ' - ' . $visita->vehicle_license_plate}} @else Sem veículo @endif <br>
    @endforeach
@stop