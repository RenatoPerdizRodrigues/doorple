<!-- Escolha de tipo de usuário a ser acessado -->

@extends('main')

@section('title', '| Main')

@section('content')
    <h1>Bem-vindo!</h1>
    <h3>Escolha seu tipo de usuário.</h3>
    <p><a href="{{ route('login') }}">Login de Usuário</a></p>
    <p><a href="{{ route('admin.login') }}">Login de Administrador</a></p>
@stop