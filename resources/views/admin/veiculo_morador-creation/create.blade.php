@extends('main')

@section('title', '| Cadastro de Veículo')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="forms border">
            <h3 class="text-center">Cadastre um novo veículo para {{$morador->name}}</h3>
            <form data-parsley-validate method="POST"  action="{{ route('veiculo_morador.store') }}">
                @csrf
                <div class="form-group">
                    <label>Tipo</label>
                    <select name="vehicle_model" class="form-control" required>
                        <option value="Carro" class="form-control">Carro</option>
                        <option value="Moto" class="form-control">Moto</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Placa</label>
                    <input type="text" id="placa" name="vehicle_license_plate" required class="form-control text-uppercase" placeholder="ABC-1234">
                </div>
                <div class="form-group">
                    <p>Dono: {{ $morador->name . " " . $morador->surname }}</p>
                    <input hidden name="morador_id" value="{{$morador->id}}" class="form-control">
                </div>            
                
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