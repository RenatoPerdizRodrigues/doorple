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

    <a href="{{route('vst.main')}}">Buscar Visitante</a><br>
@stop