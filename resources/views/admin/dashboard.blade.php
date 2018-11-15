<!-- Pàgina principal de administrador, a ser construída -->

@extends('main')

@section('title', '| Página Principal de Usuário')

@section('content')
    <h3>Bem-vindo, administrador</h3>
    @if(Auth::guard('admin')->check())
        <p>Admin está logado</p>
    @else
        <p>Admin não está logado</p>
    @endif
    @if(empty($config[0]))
        <p>Você tem configurações a fazer</p>
    @else
        <p>Seu sistema já está configurado!</p>
    @endif

    <a href="{{route('adm.create')}}">Criar Admin</a><br>
    <a href="{{route('adm.search')}}">Consultar Admin</a><br>
    <a href="{{route('admin.logout')}}">Logout</a>
@stop