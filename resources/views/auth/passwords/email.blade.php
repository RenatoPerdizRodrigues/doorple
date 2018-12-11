@extends('main')

@section('title', '| Login de Usuário')

@section('content')
    <h3>Digite seu e-mail</h3>
    <form data-parsley-validate method="POST" action="{{ route('password.email') }}">
        @csrf
        <label>E-mail:</label>
        <input type="text"name="email"><br>
        <input type="submit" value="Logar"><br><br>
    </form>
@stop