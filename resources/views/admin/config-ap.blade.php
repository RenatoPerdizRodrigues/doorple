@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
    <h3>Conclua a configuração do sistema.</h3>
    <form method="GET" action="{{ route('admin.config.ap.detail') }}">
        @csrf
        <!-- Quantidade de apartamentos, quantos apartamentos por bloco,
        prefixo de apartamentos e quantidade de incrementos -->
        <label>Quantos apartamentos há no condomínio?</label>
        <input type="number" name="howmanytotal"><br>
        <label>Quantos apartamentos há por bloco no condomínio?</label>
        <input type="number" name="howmanyblock"><br>
        <input type="submit" value="Continuar"><br><br>
    </form>
@stop