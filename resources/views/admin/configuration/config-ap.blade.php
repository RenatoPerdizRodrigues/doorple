@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
    <h3>Conclua a configuração do sistema.</h3>
    <form method="POST" action="{{ route('admin.config.ap.detail') }}">
        @csrf
        <!-- Quantidade de apartamentos, blocos -->
        <label>Quantos apartamentos há no condomínio?</label>
        <input type="number" name="total"><br>
        <label>Os apartamentos são divididos em quantos blocos?</label>
        <input type="number" name="blocos"><br>
        <input type="submit" value="Continuar"><br><br>
    </form>
@stop