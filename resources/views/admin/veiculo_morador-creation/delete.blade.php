@extends('main')

@section('title', '| Deletar Veículo')

@section('content')
<div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="forms border text-center">
                <h3 class="text-center">Deseja Deletar  {{$veiculo_morador->vehicle_model . ' | ' .$veiculo_morador->vehicle_license_plate}} de {{$veiculo_morador->morador->name}}?</h3>
                <form method="POST" action="{{ route('veiculo_morador.destroy', $veiculo_morador->id) }}">
                    @csrf
                    <a href="{{route('veiculo_morador.show', $veiculo_morador->id)}}" class="btn btn-warning">Não</a>
                    <input hidden type="text" name="_method" value="DELETE">
                    <input type="submit" value="Sim" class="btn btn-danger">
                </form>
                
            </div>
        </div>
</div>
@stop