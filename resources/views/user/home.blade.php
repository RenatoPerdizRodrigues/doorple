<!-- Pàgina principal de usuário, a ser construída -->

@extends('main')

@section('title', '| Página Principal de Usuário')

@section('content')
    <h3>Bem-vindo, usuário</h3>
    @if(Auth::guard('web')->check())
        <p>Usuário está logado</p>
    @else
        <p>Usuário não está logado</p>
    @endif
    <a href="{{route('logout')}}">Logout</a>
@stop
