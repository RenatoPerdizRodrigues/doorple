@extends('main')

@section('title', '| Index de Morador')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="forms border">
            <h3 class="text-center">Encontre um Morador</h3>
            <form method="POST" action="{{ route('morador.search.submit') }}">
                @csrf
                <div class="form-group">
                    <label>RG do Morador</label>
                    <input type="text" name="rg" class="form-control">
                </div>
                
                <input type="submit" class="btn btn-success" value="Procurar">
            </form>
        </div>
    </div>
</div>

<div class="col-md-10 offset-md-1">
    <div class="indexes">
            <h3>Lista de Moradores</h3>
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
                            <td>{{$morador->rg}}</td>
                            <td>{{$morador->birthdate}}</td>
                            <td>{{$morador->bloco->prefix . '-' . $morador->apartamento->apartamento}}</td>
                            <td><a href="{{route('morador.show', $morador->id)}}" class="btn btn-warning">Visualizar</a></td>
                        <p></p> </li>
                        </tr>
                    @endforeach
                </body>
            </table>
    </div>
</div>
@stop