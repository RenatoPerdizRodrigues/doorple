@extends('main')

@section('title', '| Cadastro de Usuário')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
                <div class="forms border">
                    <h3 class="text-center">Cadastre um novo visitante</h3>
                    <form data-parsley-validate method="POST" id="form" enctype="multipart/form-data" action="{{ route('vst.store') }}">
                        @csrf
                        <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" required>
                        </div>
                        <div class="form-group">
                                <label>Sobrenome</label>
                                <input type="text" name="surname" class="form-control" value="{{old('surname')}}" required>
                        </div>
                        <div class="form-group">
                                <label>RG</label>
                                <input type="text" name="rg" id="rg" @if(old('rg')) value="{{old('rg')}}" @else value="{{$rg}}" @endif required class="form-control  text-uppercase">
                        </div>
                        <div class="form-group">
                                <label>Data de Nascimento</label>
                                <input type="text" name="birthdate" class="form-control" value="{{old('birthdate')}}" id="date" required placeholder="DD/MM/YYYY">
                        </div>
                        <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="picture" class="form-control-file">
                        </div>
                        <input type="text" hidden name="bloco" value="{{$blocovisita}}">
                        <input type="text" hidden name="apartamento" value="{{$apartamentovisita}}">
                        
                        @if($configs[0]->visitor_car == 1)
                        <div class="form-group">
                            <!-- Carro -->
                            <h3>Visitante está visitando de carro?</h3>
                            <label>Modelo do Veículo</label>
                            <select name="vehicle_model" class="form-control">
                                <option disabled selected class="form-control">Sem Veículo</option>
                                <option value="Carro" class="form-control" @if(old('vehicle_model') == 'Carro') selected @endif>Carro</option>
                                <option value="Moto" class="form-control" @if(old('vehicle_model') == 'Moto') selected @endif>Moto</option>
                            </select>
                            <label>Placa do Veículo</label>
                            <input type="text" id="placa" name="vehicle_license_plate" value="{{old('vehicle_license_plate')}}" placeholder="Sem Veículo" class="form-control text-uppercase">
                        </div>          
                        @endif

                        <input type="submit" value="Continuar visita" class="form-control btn btn-success">
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