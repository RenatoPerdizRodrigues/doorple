@extends('main')

@section('title', '| Edição de Veículo')

@section('content')
<div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="forms border">
                <h3 class="text-center">Edição de veículo de {{$veiculo_morador->morador->name}}</h3>
                <form method="POST"  action="{{ route('veiculo_morador.update', $veiculo_morador->id) }}">
                        @csrf
                        <div class="form-group">
                                <label>Tipo</label>
                                <select name="type" class="form-control">
                                    <option @if($veiculo_morador->type == "carro") selected @endif value="carro" class="form-control">Carro</option>
                                    <option @if($veiculo_morador->type == "moto") selected @endif value="moto" class="form-control">Moto</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <label>Placa</label>
                                <input type="text" name="license_plate" value="{{$veiculo_morador->license_plate}}" class="form-control"><br>
                        </div>
                        <div class="form-group">
                                <label>Cor</label>
                                <input type="text" name="color" value="{{$veiculo_morador->color}}" class="form-control"><br>
                                <input hidden name="morador_id" value="{{$veiculo_morador->morador_id}}">
                        </div>                     
                        
                        <input hidden name="_method" value="PUT">
                        <input type="submit" value="Cadastrar" class="form-control btn btn-success">
                </form>
            </div>
        </div>
</div>
@stop