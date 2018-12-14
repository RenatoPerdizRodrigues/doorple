@extends('main')

@section('title', '| Edição de Veículo')

@section('content')
<div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="forms border">
                <h3 class="text-center">Edição de veículo de {{$veiculo_morador->morador->name}}</h3>
                <form data-parsley-validate method="POST"  action="{{ route('veiculo_morador.update', $veiculo_morador->id) }}">
                        @csrf
                        <div class="form-group">
                                <label>Tipo</label>
                                <select name="vehicle_model" class="form-control" required>
                                    <option @if($veiculo_morador->vehicle_model == "Carro") selected @endif value="Carro" class="form-control">Carro</option>
                                    <option @if($veiculo_morador->vehicle_model == "Moto") selected @endif value="Moto" class="form-control">Moto</option>
                                </select>
                        </div>
                        <div class="form-group">
                                <label>Placa</label>
                                <input type="text" name="vehicle_license_plate" required id="placa" value="{{$veiculo_morador->vehicle_license_plate}}" class="form-control text-uppercase">
                        </div>
                        
                        <input hidden name="_method" value="PUT">
                        <input type="submit" value="Cadastrar" class="form-control btn btn-success">
                </form>
            </div>
        </div>
</div>
@stop

@section('jsbody')
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#placa').mask('SSS-0000')
    });
</script>
@stop