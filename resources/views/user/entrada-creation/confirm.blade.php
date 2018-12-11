@extends('main')

@section('title', '| Confirmação de Entrada')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="forms border">
            <h3 class="text-center">Registro de entrada de morador</h3>
            <form data-parsley-validate method="POST" action="{{ route('entrada.store') }}">
                @csrf
                <p>Morador {{$morador->name . ' ' . $morador->surname}}, do apartamento {{$morador->bloco->prefix . '-' . $morador->apartamento->apartamento }}, está entrando com algum veículo?
                <hr>
                <select name="veiculo_id" class="form-control">
                    <option value="" class="form-control">Nenhum</option>
                    @foreach($morador->veiculos as $veiculo)
                        <option value={{$veiculo->id}} class="form-control">{{$veiculo->type . ' ' . $veiculo->license_plate}}</option>
                    @endforeach
                </select>
                <input hidden type="text" name="morador_id" value="{{$morador->id}}"><br>
                <input type="submit" value="Confirmar" class="form-control btn btn-success">
            </form>
        </div>
    </div>
</div>    
@stop