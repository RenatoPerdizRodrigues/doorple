@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Vamos configurar o sistema!</h3>
                <form method="POST" action="{{ route('admin.config.submit') }}">
                        @csrf
                        <div class="form-group">
                            <label>Nome do Condomínio:</label>
                            <input type="text"name="system_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>O sistema permite a entrada de visitantes com carro?</label>
                            <select name="visitor_car" class="form-control">
                                <option value="0" selected class="form-control">Não</option>
                                <option value="1" class="form-control">Sim</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Caso sim, por quanto tempo o carro pode ficar no condomínio?</label>
                            Horas: <input type="number" name="car_time_hours" class="form-control">
                            Minutos: <input type="number" name="car_time_minutes" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>O sistema requer que moradores registrem sua entrada no condomínio?</label>
                            <select name="resident_registry" class="form-control">
                                <option value="0" selected class="form-control">Não</option>
                                <option value="1" class="form-control">Sim</option>
                            </select>
                        </div>                    
                    
                        <input type="submit" value="Continuar" class="form-control btn btn-success">
                    </form>
            </div>
        </div>
</div>
@stop