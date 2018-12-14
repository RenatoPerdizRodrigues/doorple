@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Vamos configurar o sistema!</h3>
                <form data-parsley-validate method="POST" action="{{ route('admin.save.config1') }}">
                        @csrf
                        <div class="form-group">
                            <label>Nome do Condomínio:</label>
                            <input type="text"name="system_name" class="form-control" required @if($configs != null) value="{{$configs->system_name}}" @else value="{{ old('system_name')}}" @endif>
                        </div>
                        <div class="form-group">
                            <label>O sistema permite a entrada de visitantes com carro?</label>
                            <select name="visitor_car" class="form-control" id="visitor_car" required>
                                <option value="0" selected class="form-control" selected>Não</option>
                                <option value="1" class="form-control">Sim</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Caso sim, por quanto tempo o carro pode ficar no condomínio?</label>
                            Horas: <input type="number" disabled name="car_time_hours" class="form-control" id="hora" @if($horas != null) value="{{$horas}}" @else value="{{ old('car_time_hours')}}" @endif>
                            Minutos: <input type="number" disabled name="car_time_minutes" class="form-control" id="minuto" @if($minutos != null) value="{{$minutos}}" @else value="{{ old('car_time_minutes')}}" @endif>
                        </div>
                        <div class="form-group">
                            <label>O sistema requer que moradores registrem sua entrada no condomínio?</label>
                            <select name="resident_registry" class="form-control" required>
                                <option value="0" selected class="form-control" @if($configs != null) {{$configs->resident_registry == 0 ? "selected" : ""}} @elseif(old('resident_registry') == 0) selected @endif>Não</option>
                                <option value="1" class="form-control" @if($configs != null) {{$configs->resident_registry == 1 ? "selected" : ""}} @elseif(old('resident_registry') == 1) selected @endif>Sim</option>
                            </select>
                        </div>                    
                    
                        <div class="text-center">
                            <input type="submit" value="Continuar" class="btn btn-success">
                        </div>
                    </form>
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