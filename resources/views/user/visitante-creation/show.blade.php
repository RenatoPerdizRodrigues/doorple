@extends('main')

@section('title', '| Visualização de Visitante')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
                <div class="forms border">
                    <h3 class="text-center">Informações de Visitante</h3>
                    <hr>
                    <div class="row">
                            <div class="col-sm">
                                    <h3>Nome: {{$visitante->name . " " . $visitante->surname}}</h3>
                                    <h4>RG: {{$visitante->rg}}</h4>                              
                            </div>
                            <div class="col-sm mr-md-3">
                                    <img src="{{"/images/visitante/".$visitante->picture}}" class="float-right">
                            </div>
                    </div>
                            <div class="form-group text-right mt-md-3 mr-md-3">
                                    <div class="text-right">
                                        <a href="{{route('vst.edit', $visitante->id)}}" class="btn btn-success">Editar</a>
                                        <a href="{{route('vst.delete', $visitante->id)}}" class="btn btn-danger">Excluir</a>
                                    </div>
                            </div>
                </div>
        </div>
        <div class="col-md-10 offset-md-1">
                        <div class="indexes">
                                <h3>Visitas</h3>
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Bloco</th>
                                        <th>Apartamento</th>
                                        <th>Veículo</th>
                                        <th>Data</th>
                                    </thead>
                                    <tbody >
                                        @foreach($visitas as $visita)
                                            <tr>
                                                <td>{{$visita->id}}</td>
                                                <td>{{$visita->bloco->prefix}}</td> 
                                                <td>{{$visita->apartamento->apartamento}}</td>
                                                <td>{{$visita->vehicle_license_plate && $visita->vehicle_model ? $visita->visitante->vehicle_license_plate . ' ' . $visita->vehicle_model : "Sem veículo"}}</td>
                                                <td>{{$visita->created_at}}</td>
                                            <p></p>
                                            </tr>
                                        @endforeach
                                    </body>
                                </table>
                        </div>
                </div>
</div>
@stop