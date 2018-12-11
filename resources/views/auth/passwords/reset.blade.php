@extends('main')

@section('title', '| Login de Usuário')

@section('content')
    <h3>Resete sua senha</h3>
    <form data-parsley-validate method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <label>E-mail:</label>
        <input type="text"name="email" value="{{ $email ?? old('email') }}" required><br>
        <label>Senha:</label>
        <input type="password"name="password"><br>
        <label>Confirme a senha::</label>
        <input type="password"name="password_confirmation"><br>
        <input type="submit" value="Logar"><br><br>
    </form>
@stop