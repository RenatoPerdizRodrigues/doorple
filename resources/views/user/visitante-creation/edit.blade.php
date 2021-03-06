@extends('main')

@section('title', '| Edição de Visitantes')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
                <div class="forms border">
                    <h3 class="text-center">Edite o Visitante</h3>
                    <form data-parsley-validate method="POST" id="form" enctype="multipart/form-data" action="{{ route('vst.update', $visitante->id) }}">
                        @csrf
                        <!-- Visitante -->
                        <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="name" @if(old('name')) value="{{old('name')}}" @else value="{{$visitante->name}}" @endif class="form-control" required>
                        </div>
                        <div class="form-group">
                                <label>Sobrenome</label>
                                <input type="text" name="surname" @if(old('surname')) value="{{old('surname')}}" @else value="{{$visitante->surname}}" @endif class="form-control" required>
                        </div>
                        <div class="form-group">
                                <label>RG</label>
                                <input type="text" name="rg" id="rg" @if(old('rg')) value="{{old('rg')}}" @else value="{{$visitante->rg}}" @endif class="form-control text-uppercase" required>
                        </div>
                        <div class="form-group">
                                <label>Data de Nascimento</label>
                                <input type="text" name="birthdate" id="date" @if(old('birthdate')) value="{{old('birthdate')}}" @else value="{{$visitante->birthdate}}" @endif class="form-control" required>
                        </div>
                        <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="picture" class="form-control-file">
                        </div>
                        @if($configs[0]->visitor_car == 1)
                        <div class="form-group">
                            <!-- Carro -->
                            <h3>Visitante está visitando de carro?</h3>
                            <label>Modelo do Veículo</label>
                            <select name="vehicle_model" class="form-control">
                                        <option disabled selected class="form-control" @if($visitante->vehicle_license_plate == null) selected @endif>Sem Veículo</option>
                                        <option value="Carro" class="form-control" @if(old('vehicle_model') == 'Carro') selected @elseif($visitante->vehicle_model == 'Carro' && $visitante->vehicle_license_plate != null) selected @endif>Carro</option>
                                        <option value="Moto" class="form-control" @if(old('vehicle_model') == 'Moto') selected @elseif($visitante->vehicle_model == 'Moto' && $visitante->vehicle_license_plate != null && old('vehicle_model') == null) selected @endif>Moto</option>
                                    </select>
                            <label>Placa do Veículo</label>
                            <input type="text" name="vehicle_license_plate" id="placa" class="form-control text-uppercase" @if(old('vehicle_license_plate')) value="{{old('vehicle_license_plate')}}" @elseif($visitante->vehicle_license_plate) value="{{$visitante->vehicle_license_plate}}" @endif>
                        </div>            
                        @endif
                        <input hidden name="_method" value="PUT">
                        <input type="submit" value="Editar Visitante" class="form-control btn btn-success">
                    </form>
                </div>
        </div>
</div>
@stop

@section('jsbody')
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#date').mask('00/00/0000')
        $('#placa').mask('SSS-0000')
        $('#rg').mask('99.999.999-W', {
            translation: {
                'W' : {
                    pattern: /[Xx0-9]/
                }
            },
            reverse: true
        })
    });

    $("#form").submit(function() {
        if ($(this).parsley().isValid()) {
            $("#date").unmask();
            $("#date").mask('00-00-0000')
            $("#rg").unmask();
        }
    });

</script>
@stop