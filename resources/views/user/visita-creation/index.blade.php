@extends('main')

@section('title', '| Index de Visitas')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="forms border">
            <h3 class="text-center">Procure uma visita através do dia, mês e ano</h3>
            <form method="POST" action="{{ route('visita.search.submit') }}">
                @csrf
                <div class="form-group">
                        <label>Dia da Visita</label>
                    <input type="date" name="date" class="form-control">
                </div>                
                <div class="text-center">
                    <input type="submit" class="btn btn-success" value="Procurar">
                </div>
            </form>
        </div>
    </div>
</div>

<div class="col-md-10 offset-md-1">
    <div class="indexes">
            <h3>Visitas do dia</h3>
            @if(empty($visitas[0]))
                Não há visitas registradas para este dia
            @else

                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Visitante</th>
                        <th>Apartamento Visitado</th>
                        <th>Veículo</th>
                        <th>Data</th>
                    </thead>
                    <tbody >
                        @foreach($visitas as $visita)
                            <tr>
                                <td>{{$visita->id}}</td> 
                                <td>{{$visita->visitante->name . ' ' . $visita->visitante->surname}}</td>
                                <td>{{$visita->bloco->prefix . '-' . $visita->apartamento->apartamento}}</td>
                                <td>@if($visita->vehicle_license_plate && $visita->vehicle_model) {{$visita->vehicle_model . ' - ' . $visita->vehicle_license_plate}} @else Sem veículo @endif</td>
                                <td>{{$visita->created_at}}</td>
                            <p></p> </li>
                            </tr>
                        @endforeach
                    </body>
                </table>
                @endif
                <div class="text-center">
                        {{ $visitas->links() }}
                </div>
    </div>
</div>
@stop