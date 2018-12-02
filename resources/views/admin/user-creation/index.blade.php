@extends('main')

@section('title', '| Index de Usuário')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="forms border">
            <h3 class="text-center">Encontre um Admin</h3>
                <form method="POST" action="{{ route('usr.search.submit') }}">
                    @csrf
                    <div class="formgroup">
                        <label>Email do User</label>
                        <input type="text" name="email" class="form-control"><br>
                    </div>
                    
                    <input type="submit" value="Procurar" class="form-control btn btn-success">
                </form><br><br>
        </div>
    </div>
    <div class="col-md-10 offset-md-1">
        <div class="indexes">
                <h3>Lista de Usuários</h3>
                @if($users->isEmpty())
                    Não há usuários cadastrados.
                @else
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ações</th>
                    </thead>
                    <tbody >
                        @foreach($users as $user)
                            <tr>
                                <td>{{$user->id}}</td> 
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td><a href="{{route('usr.show', $user->id)}}" class="btn btn-warning">Visualizar</a></td>
                            </tr>
                        @endforeach
                    </body>
                </table>
                {!! $users->links(); !!}
                @endif
        </div>
    </div>
</div>
@stop