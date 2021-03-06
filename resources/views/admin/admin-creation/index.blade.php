@extends('main')

@section('title', '| Index de Administrador')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Encontre um Admin</h3>
                    <form data-parsley-validate method="POST" action="{{ route('adm.search.submit') }}">
                        @csrf
                        <div class="form-group">
                            <label>Email do Adm</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="form-control btn btn-success" value="Procurar">
                        </div>
                    </form>
            </div>
        </div>
        <div class="col-md-10 offset-md-1">
            <div class="indexes">
                    <h3>Lista de Admins</h3>
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Ações</th>
                        </thead>
                        <tbody >
                            @foreach($admins as $admin)
                                <tr>
                                    <td>{{$admin->id}}</td> 
                                    <td>{{$admin->name}}</td>
                                    <td>{{$admin->email}}</td>
                                    <td><a href="{{route('adm.show', $admin->id)}}" class="btn btn-warning">Visualizar</a></td>
                                <p></p> </li>
                                </tr>
                            @endforeach
                        </body>
                    </table>
                    {!! $admins->links(); !!}
            </div>
        </div>
</div>


@stop