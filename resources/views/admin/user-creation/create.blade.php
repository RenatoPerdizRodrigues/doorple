@extends('main')

@section('title', '| Cadastro de Usuário')

@section('content')
<h3>Cadastre um novo Usuário</h3>
    <form method="POST" action="{{ route('usr.store') }}">
        @csrf
        <label>Nome</label>
        <input type="text" name="name"><br>
        <label>Email</label>
        <input type="text" name="email"><br>
        <label>Senha</label>
        <input type="password" name="password"><br>
        <label>Confirme a senha</label>
        <input type="password" name="password-confirmation"><br>
        <input type="submit" value="Cadastrar">
    </form>
@stop