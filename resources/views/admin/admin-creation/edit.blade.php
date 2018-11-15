@extends('main')

@section('title', '| Cadastro de Administrador')

@section('content')
<h3>Cadastre um novo Admin</h3>
    <form method="POST" action="{{ route('adm.update', $admin->id) }}">
        @csrf
        <label>Nome</label>
        <input type="text" name="name" value="{{$admin->name}}"><br>
        <label>Email</label>
        <input type="text" name="email" value="{{$admin->email}}"><br>
        <label>Senha</label>
        <input type="password" name="password" value="{{$admin->password}}"><br>
        <label>Confirme a senha</label>
        <input type="password" name="password-confirmation" value="{{$admin->password}}"><br>
        <input hidden type="text" name="_method" value="PUT">
        <input type="submit" value="Cadastrar">
    </form>
@stop