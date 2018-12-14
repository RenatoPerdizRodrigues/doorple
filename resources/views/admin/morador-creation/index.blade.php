@extends('main')

@section('title', '| Index de Morador')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="forms border">
            <h3 class="text-center">Encontre um Morador</h3>
            <form data-parsley-validate method="POST" id="form" action="{{ route('morador.search.submit') }}">
                @csrf
                <div class="form-group">
                    <label>RG do Morador</label>
                    <input type="text" name="rg" id ="rg" required class="form-control  text-uppercase">
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
            <h3>Lista de Moradores</h3>
            @if($moradores->isEmpty())
                Não há moradores cadastrados.
            @else
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>RG</th>
                        <th>Data de Nascimento</th>
                        <th>Apartamento</th>
                        <th>Ações</th>
                    </thead>
                    <tbody >
                        @foreach($moradores as $morador)
                            <tr>
                                <td>{{$morador->id}}</td> 
                                <td>{{$morador->name}}</td>
                                <td>{{$morador->surname}}</td>
                                <td><input type="text" disabled value="{{$morador->rg}}" class="rg_view rg2"></td>
                                <td>{{$morador->birthdate}}</td>
                                <td>{{$morador->bloco->prefix . '-' . $morador->apartamento->apartamento}}</td>
                                <td><a href="{{route('morador.show', $morador->id)}}" class="btn btn-warning">Visualizar</a></td>
                            <p></p> </li>
                            </tr>
                        @endforeach
                    </body>
                </table>
                {!! $moradores->links(); !!}
            @endif
    </div>
</div>
@stop

@section('jsbody')
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.rg2').mask('99.999.999-W', {
            translation: {
                'W' : {
                    pattern: /[Xx0-9]/
                }
            },
            reverse: true
        })
        $('#rg').mask('99.999.999-W', {
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