@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
    <h3>Vamos configurar o sistema!</h3>
    <form method="POST" action="{{ route('admin.config.submit') }}">
        @csrf
        <label>Nome do Condomínio:</label>
        <input type="text"name="system_name"><br>
        <label>O sistema permite a entrada de visitantes com carro?</label>
        <select name="visitor_car">
            <option value="1" selected>Sim</option>
            <option value="0" selected>Não</option>
        </select><br>
        <label>O sistema requer que moradores registrem sua entrada no condomínio?</label>
        <select name="resident_registry">
                <option value="1" selected>Sim</option>
                <option value="0" selected>Não</option>
            </select><br>
        <input type="submit" value="Continuar"><br><br>
    </form>
@stop