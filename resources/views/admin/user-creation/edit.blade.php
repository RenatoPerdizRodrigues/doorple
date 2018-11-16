@extends('main')

@section('title', '| Edição de Usuário')

@section('content')
<h3>Edite um Usuário</h3>
    <form method="POST" action="{{ route('usr.update', $user->id) }}">
        @csrf
        <label>Nome</label>
        <input type="text" name="name" value="{{$user->name}}"><br>
        <label>Email</label>
        <input type="text" name="email" value="{{$user->email}}"><br>
        <label>Senha</label>
        <input type="password" name="password"><br>
        <label>Confirme a senha</label>
        <input type="password" name="password-confirmation"><br>
        <input hidden type="text" name="_method" value="PUT">
        <input type="submit" value="Cadastrar">
    </form>
@stop