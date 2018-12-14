@extends('main')

@section('title', '| Index de Visitante')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Encontre um Visitante</h3>
                <form data-parsley-validate method="POST" id="form" action="{{ route('vst.find.submit') }}">
                    @csrf
                    <div class="form-group">
                            <label>RG do Visitante</label>
                        <input type="text" name="rg" id="rg" class="form-control text-uppercase" required>
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
                <h3>Lista de Visitantes</h3>
                @if($visitantes->isEmpty())
                    Não há visitantes cadastrados para este dia.
                @else
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>RG</th>
                        <th>Data de Nascimento</th>
                        <th>Ações</th>
                    </thead>
                    <tbody >
                        @foreach($visitantes as $visitante)
                            <tr>
                                <td>{{$visitante->id}}</td> 
                                <td>{{$visitante->name}}</td>
                                <td>{{$visitante->surname}}</td>
                                <td><input type="text" disabled value="{{$visitante->rg}}" class="rg_view rg2"></td>
                                <td>{{$visitante->birthdate}}</td>
                                <td><a href="{{route('vst.show', $visitante->id)}}" class="btn btn-warning">Visualizar</a></td>
                            <p></p> </li>
                            </tr>
                        @endforeach
                    </body>
                </table>
                {!! $visitantes->links(); !!}
                @endif
        </div>
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
        $('.rg2').mask('99.999.999-W', {
            translation: {
                'W' : {
                    pattern: /[Xx0-9]/
                }
            },
            reverse: true
        })
    });

    $("#form").submit(function() {
        if ($(this).parsley().isValid()) {
            $("#rg").unmask();
        }
    });

</script>
@stop