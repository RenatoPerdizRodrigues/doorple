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
    <a href="{{route('admin.logout')}}">Logout</a>
@stop