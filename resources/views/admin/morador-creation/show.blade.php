@extends('main')

@section('title', '| Visualização de Morador')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
                <div class="forms border">
                    <h3 class="text-center">Informações de Morador</h3>
                    <hr>
                    <div class="row">
                            <div class="col-sm">
                                    <h3>{{$morador->name . " " . $morador->surname}}</h3>
                                    <h5>RG: <input type="text" disabled id="rg" value="{{$morador->rg}}" class="rg_view text-uppercase"></h5>
                                    <h5>Data de Nascimento: {{$morador->birthdate}}</h5>
                                    <h5>Apartamento: {{$morador->bloco->prefix . "-" . $morador->apartamento->apartamento}}</h5>                              
                            </div>
                            <div class="col-sm mr-md-3">
                                    <img src="{{"/images/morador/".$morador->picture}}" class="float-right">
                            </div>
                    </div>
                            <div class="form-group text-right mt-md-3 mr-md-3">
                                @if(Auth::guard('admin')->check() == 1)
                                    <div class="text-right">
                                        @if($configs[0]->resident_registry == 1)
                                            <a href="{{route('veiculo_morador.create', $morador->id)}}" class="btn btn-warning">Adicionar Veículo</a>
                                        @endif
                                        <a href="{{route('morador.edit', $morador->id)}}" class="btn btn-success">Editar</a>
                                        <a href="{{route('morador.delete', $morador->id)}}" class="btn btn-danger">Excluir</a>
                                    </div>
                                @endif
                            </div>
                </div>
        </div>
        <div class="col-md-10 offset-md-1">
                        <div class="indexes">
                                <h3>Veículos</h3>
                                @if(count($morador->veiculos) == 0)
                                    Não há veículos cadastrados para este morador.
                                @else
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Modelo</th>
                                        <th>Placa</th>
                                    </thead>
                                    <tbody >
                                        @foreach($morador->veiculos as $veiculo)
                                            <tr>
                                                <td>{{$veiculo->id}}</td> 
                                                <td>{{$veiculo->vehicle_model}}</td>
                                                @if(Auth::guard('admin')->check() == 1)
                                                    <td><a href="{{route('veiculo_morador.show', $veiculo->id)}}">{{$veiculo->vehicle_license_plate}}</a></td>
                                                @else
                                                    <td>{{$veiculo->vehicle_license_plate}}</td>
                                                @endif
                                            <p></p>
                                            </tr>
                                        @endforeach
                                    </body>
                                </table>
                                @endif
                        </div>
                </div>
        @if($configs[0]->resident_registry == 1)
        <div class="col-md-10 offset-md-1">
                <div class="indexes">
                        <h3>Registro de Entradas</h3>
                        @if(count($entradas) == 0)
                            Não há entradas registradas para este morador.
                        @else
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Data</th>
                                <th>Veículo</th>
                            </thead>
                            <tbody >
                                @foreach($entradas as $entrada)
                                    <tr>
                                        <td>{{$entrada->id}}</td> 
                                        @if(Auth::guard('web')->check() == 1)
                                            <td><a href="{{route('entrada.index', $entrada->created_at->format('Y-m-d'))}}">{{$entrada->created_at->format('d/m/Y | H:i:s')}}</a></td>
                                        @else
                                           <td>{{$entrada->created_at->format('d/m/Y | H:i:s')}}</td>
                                        @endif
                                        <td>{{!empty($entrada->veiculo) ? $entrada->veiculo->vehicle_model . ' ' . $entrada->veiculo->vehicle_license_plate : "Sem Veículo"}}</td>
                                    <p></p>
                                    </tr>
                                @endforeach
                            </body>
                        </table>
                        @endif
                </div>
        </div>
        @endif
</div>
@stop

@section('jsbody')
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#rg').mask('99.999.999-W', {
            translation: {
                'W' : {
                    pattern: /[Xx0-9]/
                }
            },
            reverse: true
        })
    });

</script>
@stop