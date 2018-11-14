@extends('main')

@section('title', '| Login de Administrador')

@section('content')
    <h3>Login de Administrador</h3>
    <form method="POST" action="{{ route('admin.login.submit') }}">
        @csrf
        <label>E-mail:</label>
        <input type="text"name="email"><br>
        <label>Password:</label>
        <input type="password"name="password"><br>
        <input type="submit" value="Logar"><br><br>
        <a href="{{route('admin.password.request')}}">Esqueci minha senha</a>
    </form>
@stop