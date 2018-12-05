@extends('main')

@section('title', '| Visualização de Morador')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Informações de veículo</h3>
                <hr>
                <h3>Placa: {{$veiculo_morador->vehicle_license_plate}}</h3>
                <h4>Modelo: {{$veiculo_morador->vehicle_model}}</h4>
                <h4>Dono: <a href="{{route('morador.show', $veiculo_morador->morador->id)}}">{{$veiculo_morador->morador->name}}</a></h4>
                <div class="text-right">
                    <a href="{{route('veiculo_morador.edit', $veiculo_morador->id)}}" class="btn btn-warning">Editar</a>
                    <a href="{{route('veiculo_morador.delete', $veiculo_morador->id)}}" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
</div>
@stop