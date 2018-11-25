<!-- Pàgina principal de administrador, a ser construída -->

@extends('main')

@section('title', '| Página Principal de Usuário')

@section('content')
    <h3>Bem-vindo, administrador</h3>
    @if(Auth::guard('web')->check())
        <p>Usuário está logado</p>
    @else
        <p>Usuário não está logado</p>
    @endif

    <a href="{{route('vst.main')}}">Nova Visita</a><br>

    <h2>Últimas Visitas</h2>
    @foreach($visitas as $visita)
    
        Visitante: {{$visita->visitante->name . ' ' . $visita->visitante->surname}} | Apartamento {{$visita->bloco->prefix . '-' . $visita->apartamento->apartamento}} | @if($visita->vehicle_license_plate && $visita->vehicle_model) {{$visita->vehicle_model . ' - ' . $visita->vehicle_license_plate}} @else Sem veículo @endif <br>
    @endforeach
@stop