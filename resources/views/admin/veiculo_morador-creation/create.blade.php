@extends('main')

@section('title', '| Cadastro de Veículo')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="forms border">
            <h3 class="text-center">Cadastre um novo veículo para {{$morador->name}}</h3>
            <form method="POST"  action="{{ route('veiculo_morador.store') }}">
                @csrf
                <div class="form-group">
                    <label>Tipo</label>
                    <select name="type" class="form-control">
                        <option value="carro" class="form-control">Carro</option>
                        <option value="moto" class="form-control">Moto</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Placa</label>
                    <input type="text" name="license_plate" class="form-control">
                </div>
                <div class="form-group">
                    <label>Cor</label>
                    <input type="text" name="color" class="form-control">
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