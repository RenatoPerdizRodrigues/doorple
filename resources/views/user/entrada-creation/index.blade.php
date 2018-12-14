@extends('main')

@section('title', '| Index de Visitas')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="forms border">
            <h3 class="text-center">Procure uma entrada através do dia, mês e ano</h3>
            <form data-parsley-validate method="POST" action="{{ route('entrada.search.submit') }}">
                @csrf
                <div class="form-group">
                    <label>Dia da Entrada</label>
                    <input type="text" name="date" required class="form-control" id="date" placeholder="DD/MM/YYY">
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
            <h3>Entradas do dia @if(!empty($entradas[0])) {{$entradas[0]->created_at->format('d/m/Y')}}@endif</h3>
            @if(empty($entradas[0]))
                Não há entradas registradas para este dia
            @else

                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Morador</th>
                        <th>Veículo</th>
                        <th>Data</th>
                    </thead>
                    <tbody >
                        @foreach($entradas as $entrada)
                            <tr>
                                <td>{{$entrada->id}}</td> 
                                <td>{{$entrada->morador->name . ' ' . $entrada->morador->surname}}</td>
                                <td>{{$entrada->veiculo ? $entrada->veiculo->vehicle_model . '-' . $entrada->veiculo->vehicle_license_plate : "Sem veículo"}}</td>
                                <td>{{$entrada->created_at->format('d/m/Y | H:i:s')}}</td>
                            <p></p> </li>
                            </tr>
                        @endforeach
                    </body>
                </table>
                @endif
                {!! $entradas->links(); !!}
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