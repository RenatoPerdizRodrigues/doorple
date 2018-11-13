@extends('main')

@section('title', '| Login de Usuário')

@section('content')
    <h3>Login de Usuário</h3>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>E-mail:</label>
        <input type="text"name="email"><br>
        <label>Password:</label>
        <input type="password"name="password"><br>
        <input type="submit" value="Logar"><br><br>
        <a href="{{route('password.request')}}">Esqueci minha senha</a>
    </form>
@stop