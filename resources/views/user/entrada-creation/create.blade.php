@extends('main')

@section('title', '| Cadastro de Entrada')

@section('content')
<h3>Registro de entrada de morador</h3>
    <form method="POST" action="{{ route('entrada.confirm') }}">
        @csrf
        <!-- Visitante -->
        <label>RG do morador</label>
        <input type="text" name="rg"><br>
        <input type="submit" value="Encontrar Morador">
    </form>
@stop