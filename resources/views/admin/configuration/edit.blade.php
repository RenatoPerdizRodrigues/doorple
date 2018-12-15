@extends('main')

@section('title', '| Edição de Sistema')

@section('content')
{{old('resident_registry')}}
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Vamos configurar o sistema!</h3>
                <form data-parsley-validate method="POST" action="{{route('admin.config.update')}}">
                        @csrf
                        <div class="form-group">
                            <!-- Edição do nome de blocos -->
                            <h4>Edite o Nome do Bloco</h4>
                            @foreach($blocos as $bloco)
                                <label>Bloco {{$bloco->id}}:</label>
                                <input type="text" class="form-control" required name="bloco_{{$bloco->id}}" @if(old('bloco_' . $bloco->id)) value="{{old('bloco_' . $bloco->id)}}" @else value="{{$bloco->prefix}}" @endif>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <!-- Edição de configurações -->
                            <h4>Edite suas Configurações</h4>
                            <label>Nome do Sistema: </label>
                            <input type="text" class="form-control" name="system_name" required @if(old('system_name')) value="{{old('system_name')}}" @else value="{{$configs->system_name}}" @endif>
                            <label>Visitante pode entrar com Carro? </label>
                            <select name="visitor_car" class="form-control" id="visitor_car" required>
                                <option value="1" class="form-control" @if(old('visitor_car') == 1) selected @elseif($configs->visitor_car == 1) selected @endif>Sim</option>
                                <option value="0" class="form-control" @if(old('visitor_car') == 0) selected @elseif($configs->visitor_car == 0) selected @endif>Não</option>
                            </select>
                            <label>Tempo que carro de visitante pode ficar no condomínio</label>
                            Horas: <input type="number" class="form-control" name="car_time_hours" id="hora" @if($configs->visitor_car == 0) disabled @endif @if(old('car_time_hours')) value="{{old('car_time_hours')}}" {{old('car_time_hours')}} @else value="{{$horas}}" @endif>
                            Minutos: <input type="number" class="form-control" name="car_time_minutes" id="minuto" @if($configs->visitor_car == 0) disabled @endif @if(old('car_time_minutes')) value="{{old('car_time_minutes')}}" {{old('car_time_minutes')}} @else value="{{$minutos}}" @endif>
                            <label>Morador deve ter entrada registrada? </label>
                            <select name="resident_registry" class="form-control" required>
                                <option value="1" class="form-control" @if(old('resident_registry') == 1) selected @elseif($configs->resident_registry == 1) selected @endif>Sim</option>
                                <option value="0" class="form-control" @if(old('resident_registry') == 0) selected @elseif($configs->resident_registry == 0) selected @endif>Não</option>
                            </select>
                        </div>
                        
                    
                        
                        <input hidden name="howmanyblocks" value="{{$configs->howmanyblocks}}">
                        <input hidden name="_method" value="PUT">
                        <input type="submit" class="form-control btn btn-success" value="Editar">
                </form>
            </div>
            <hr>
            <h1 class="text-center">Ou...</h1>
            <hr>
            <!-- Acrescentar um novo apartamento -->
            <div class="text-center">
                    <a href="{{route('admin.config.create')}}" class="btn btn-secondary">Cadastre um Novo Apartamento</a>
            </div>
        </div>
</div>
@stop

@section('jsbody')
<script>
    $(document).ready(function(){
        $("#visitor_car").change(function(){
            //Valor do select de bloco
            var val = $(this).val();

            if (val == 0){
                document.getElementById("hora").disabled = true;
                document.getElementById("minuto").disabled = true;
            } else if (val == 1){
                document.getElementById("hora").disabled = false;
                document.getElementById("minuto").disabled = false;
            }
        });
    });
</script>
@stop