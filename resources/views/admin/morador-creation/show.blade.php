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
                                    <h3>Nome: {{$morador->name . " " . $morador->surname}}</h3>
                                    <h4>RG: {{$morador->rg}}</h4>
                                    <h4>Apartamento: {{$morador->bloco->prefix . "-" . $morador->apartamento->apartamento}}</h4>                              
                            </div>
                            <div class="col-sm mr-md-3">
                                    <img src="{{"/images/morador/".$morador->picture}}" class="float-right">
                            </div>
                    </div>
                            <div class="form-group text-right mt-md-3 mr-md-3">
                                    <div class="text-right">
                                        @if($configs[0]->resident_registry == 1)
                                            <a href="{{route('veiculo_morador.create', $morador->id)}}" class="btn btn-warning">Adicionar Veículo</a>
                                        @endif
                                        <a href="{{route('morador.edit', $morador->id)}}" class="btn btn-success">Editar</a>
                                        <a href="{{route('morador.delete', $morador->id)}}" class="btn btn-danger">Excluir</a>
                                    </div>
                            </div>
                </div>
        </div>
        <div class="col-md-10 offset-md-1">
                        <div class="indexes">
                                <h3>Veículos</h3>
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
                                                <td>{{$veiculo->type}}</td>
                                                <td><a href="{{route('veiculo_morador.show', $veiculo->id)}}">{{$veiculo->license_plate}}</a></td>
                                            <p></p>
                                            </tr>
                                        @endforeach
                                    </body>
                                </table>
                        </div>
                </div>
        <div class="col-md-10 offset-md-1">
                <div class="indexes">
                        <h3>Registro de Entradas</h3>
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
                                        <td>{{$entrada->morador->name . ' ' . $entrada->morador->surname}}</td>
                                        <td>{{!empty($entrada->veiculo) ? $entrada->veiculo->type . ' ' . $entrada->veiculo->license_plate : "Sem Veículo"}}</td>
                                    <p></p>
                                    </tr>
                                @endforeach
                            </body>
                        </table>
                </div>
        </div>
</div>
@stop