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
                                    <h3>{{$visitante->name . " " . $visitante->surname}}</h3>
                                    <h5>RG: {{$visitante->rg}}</h5>
                                    <h5>Data de Nascimento: {{$visitante->birthdate}}</h5>           
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
                                        @if($configs[0]->visitor_car == 1)
                                        <th>Veículo</th>
                                        @endif
                                        <th>Data</th>
                                    </thead>
                                    <tbody >
                                        @foreach($visitas as $visita)
                                            <tr>
                                                <td>{{$visita->id}}</td>
                                                <td>{{$visita->bloco->prefix}}</td> 
                                                <td>{{$visita->apartamento->apartamento}}</td>
                                                @if($configs[0]->visitor_car == 1)
                                                <td>{{$visita->vehicle_license_plate && $visita->vehicle_model ? $visita->visitante->vehicle_license_plate . ' ' . $visita->vehicle_model : "Sem veículo"}}</td>
                                                @endif
                                                <td>{{$visita->created_at->format('d/m/Y | H:i:s')}}</td>
                                            <p></p>
                                            </tr>
                                        @endforeach
                                    </body>
                                </table>
                        </div>
                </div>
</div>
@stop