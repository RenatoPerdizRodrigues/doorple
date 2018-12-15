@extends('main')

@section('title', '| Index de Visitas')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="forms border">
            <h3 class="text-center">Procure uma visita através do dia, mês e ano</h3>
            <form data-parsley-validate method="POST" action="{{ route('visita.search.submit') }}">
                @csrf
                <div class="form-group">
                        <label>Dia da Visita</label>
                    <input type="text" name="date" class="form-control" id="date" placeholder="DD/MM/YYYY" required>
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
            <h3>Visitas do dia @if(!empty($visitas[0])) {{$visitas[0]->created_at->format('d/m/Y')}} @endif</h3>
            @if(empty($visitas[0]))
                Não há visitas registradas para este dia
            @else

                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Visitante</th>
                        <th>Apartamento Visitado</th>
                        @if($configs[0]->visitor_car == 1)
                        <th>Veículo</th>
                        @endif
                        <th>Data</th>
                    </thead>
                    <tbody >
                        @foreach($visitas as $visita)
                            <tr>
                                <td>{{$visita->id}}</td> 
                                <td><a href="{{route('vst.show', $visita->visitante->id)}}">{{$visita->visitante->name . ' ' . $visita->visitante->surname}}</a></td>
                                <td><a href="{{route('admin.config.index', $visita->bloco->prefix)}}">{{$visita->bloco->prefix . '-' . $visita->apartamento->apartamento}}</a></td>
                                @if($configs[0]->visitor_car == 1)
                                <td>@if($visita->vehicle_license_plate && $visita->vehicle_model) {{$visita->vehicle_model . ' - ' . $visita->vehicle_license_plate}} @else Sem veículo @endif</td>
                                @endif
                                <td>{{$visita->created_at->format('d/m/Y | H:i:s')}}</td>
                            <p></p> </li>
                            </tr>
                        @endforeach
                    </body>
                </table>
                @endif
                {!! $visitas->links(); !!}
    </div>
</div>
@stop

@section('jsbody')
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#date').mask('00/00/0000')
    });
</script>
@stop