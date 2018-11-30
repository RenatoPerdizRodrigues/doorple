@extends('main')

@section('title', '| Visualização de Morador')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Informações de veículo</h3>
                <hr>
                <h3>Placa: {{$veiculo_morador->license_plate}}</h3>
                <h4>Cor: {{$veiculo_morador->color}}</h4>
                <h4>Dono: {{$veiculo_morador->morador->name}}</h4>
                <div class="text-right">
                    <a href="{{route('veiculo_morador.edit', $veiculo_morador->id)}}" class="btn btn-warning">Editar</a>
                    <a href="{{route('veiculo_morador.delete', $veiculo_morador->id)}}" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
</div>
@stop