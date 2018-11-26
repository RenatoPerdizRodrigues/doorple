@extends('main')

@section('title', '| Edição de Sistema')

@section('content')
<h3>Edite as configurações do Sistema</h3>
<form method="POST" action="{{route('admin.config.update')}}">
    @csrf
    <!-- Edição do nome de blocos -->
    <h2>Edite o Nome do Bloco</h2>
    @foreach($blocos as $bloco)
    <label>Bloco {{$bloco->id}}:</label><br>
    <input type="text" name="bloco_{{$bloco->id}}" value="{{$bloco->prefix}}"><br><br>
    @endforeach

    <!-- Edição de configurações -->
    <h2>Edite suas Configurações</h2>
    <label>Nome do Sistema: </label><br>
    <input type="text" name="system_name" value="{{$configs->system_name}}"><br><br>
    <label>Visitante pode entrar com Carro? </label><br>
    <select name="visitor_car">
        <option value="1" {{$configs->visitor_car == 1 ? "selected" : ""}}>Sim</option>
        <option value="0" {{$configs->visitor_car == 0 ? "selected" : ""}}>Não</option>
    </select><br><br>
    <label>Tempo que carro de visitante pode ficar no condomínio</label><br>
    Horas: <input type="number" name="car_time_hours" value="{{$horas}}"><br>
    Minutos: <input type="number" name="car_time_minutes" value="{{$minutos}}"><br>
    <label>Morador deve ter entrada registrada? </label><br>
    <select name="resident_registry">
        <option value="1" {{$configs->resident_registry == 1 ? "selected" : ""}}>Sim</option>
        <option value="0" {{$configs->resident_registry == 0 ? "selected" : ""}}>Não</option>
    </select><br><br>
    <input hidden name="howmanyblocks" value="{{$configs->howmanyblocks}}">
    <input hidden name="_method" value="PUT">
    <input type="submit" value="Editar">
</form><br>
<h2>Ou...</h2>
<!-- Acrescentar um novo apartamento -->
<a href="{{route('admin.config.create')}}">Cadastre um Novo Apartamento</a>
@stop