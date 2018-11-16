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
    <a href="{{route('adm.index')}}">Consultar Admin</a><br><br>
    <a href="{{route('usr.create')}}">Criar Usuário</a><br>
    <a href="{{route('usr.index')}}">Consultar Usuário</a><br><br>
    <a href="{{route('morador.create')}}">Criar Morador</a><br>
    <a href="{{route('morador.index')}}">Consultar Morador</a><br><br>
    <a href="{{route('admin.logout')}}">Logout</a>
@stop