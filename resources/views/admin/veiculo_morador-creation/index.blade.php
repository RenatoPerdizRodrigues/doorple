@extends('main')

@section('title', '| Index de Veículo')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Encontre um Veículo</h3>
                <form data-parsley-validate method="POST" action="{{ route('veiculo_morador.search.submit') }}">
                        @csrf
                        <div class="form-group">
                            <label>Placa do Motorista</label>
                            <input type="text" name="license_plate" id="placa" class="form-control">
                        </div>
                        <div class="text-center">
                            <input type="submit" value="Procurar" class="btn btn-success">
                        </div>
                    </form>
            </div>
        </div>
</div>

<div class="col-md-10 offset-md-1">
        <div class="indexes">
                <h3>Lista de Veículos</h3>
                @if($veiculos_morador->isEmpty())
                    Não há veículos cadastrados.
                @else
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Placa</th>
                        <th>Modelo</th>
                        <th>Dono</th>
                        <th>Apartamento do Dono</th>
                    </thead>
                    <tbody >
                        @foreach($veiculos_morador as $veiculo)
                            <tr>
                                <td>{{$veiculo->id}}</td> 
                                <td>{{$veiculo->vehicle_license_plate}}</td>
                                <td>{{$veiculo->vehicle_model}}</td>
                                <td><a href="{{route('morador.show', $veiculo->morador->id)}}">{{$veiculo->morador->name . ' ' . $veiculo->morador->surname}}</a></td>
                                <td>{{$veiculo->morador->bloco->prefix . '-' . $veiculo->morador->apartamento->apartamento}}</td>
                                <td><a href="{{route('veiculo_morador.show', $veiculo->id)}}" class="btn btn-warning">Visualizar</a></td>
                            <p></p> </li>
                            </tr>
                        @endforeach
                    </body>
                </table>
                {!! $veiculos_morador->links(); !!}
                @endif
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