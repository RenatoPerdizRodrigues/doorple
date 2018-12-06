@extends('main')

@section('title', '| Cadastro de Usuário')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
                <div class="forms border">
                        <form method="POST" action="{{ route('visita.store') }}">
                                @csrf
                                
                    <h3 class="text-center">Dados da Visita</h3>
                    <div class="form-group">
                            <h2>Visitante</h2>
                            <!-- Visitante -->
                            <label>Nome</label>
                            <input type="text" name="name" disabled value="{{$visitante->name}}" class="form-control">
                            <label>Sobrenome</label>
                            <input type="text" name="surname" disabled value="{{$visitante->surname}}" class="form-control">
                            <input hidden name="visitante_id" value="{{$visitante->id}}">
                    </div>
                    <div class="form-group">
                            <!-- Apartamento a ser visitado -->
                            <label>Qual apartamento o visitante deseja visitar?</label>
                        <label>Bloco</label>
                        <select name="blocoview" disabled class="form-control">
                            @foreach($blocos as $blocos)
                                <option value="{{$blocos->id}}" class="form-control" @if($bloco == $blocos->id) selected @endif>{{$blocos->prefix}}</option>
                            @endforeach
                        </select>
                        <label>Apartamento</label>
                        <select name="apartamentoview" disabled class="form-control">
                            @foreach($apartamentos as $apartamentos)
                                    <option value="{{$apartamentos->apartamento}}" class="form-control" @if($apartamento == $apartamentos->id) selected @endif>{{$apartamentos->apartamento}}</option>
                            @endforeach
                        </select>
                    </div>
                    @if($configs[0]->visitor_car == 1)
                    <div class="form-group">
                            <!-- Carro -->
                            <h2>Está visitando de veículo?</h2>
                            <select name="vehicle" id="vehicle" class="form-control">
                                    <option value="0" class="form-control" selected>Não</option>
                                    <option value="1" class="form-control">Sim</option>
                            </select>
                            <label>Modelo do Veículo</label>
                            <select name="vehicle_model" id="modelo" disabled class="form-control">
                                <option value="Carro" class="form-control" @if($modelo == 'Carro') selected @endif>Carro</option>
                                <option value="Moto" class="form-control" @if($modelo == 'Moto') selected @endif>Moto</option>
                            </select>
                            <label>Placa do Veículo</label>
                            <input type="text" name="vehicle_license_plate" disabled id="placa" value="{{$placa}}" placeholder="Sem Veículo" class="form-control text-uppercase">
                    </div>
                    @endif
                    <input type="text" hidden name="bloco" value="{{$bloco}}">
                    <input type="text" hidden name="apartamento" value="{{$apartamento}}">
                            <input type="submit" value="Cadastrar visita" class="form-control btn btn-success">
                            </form>
@stop

@section('jsbody')
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#placa').mask('SSS-0000')
    });

    $("#vehicle").change(function(){
            //Valor do select de bloco
            var val = $(this).val();

            if (val == 1){
                document.getElementById("placa").disabled = false;
                document.getElementById("modelo").disabled = false;
            } else if (val == 0){
                document.getElementById("placa").disabled = true;
                document.getElementById("modelo").disabled = true;
            }
        });
</script>
@stop