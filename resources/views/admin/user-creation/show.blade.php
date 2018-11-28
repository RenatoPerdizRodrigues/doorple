@extends('main')

@section('title', '| Visualização de Usuário')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Informações de Usuário</h3>
                <h3>{{$user->name}}</h3>
                <h4>{{$user->email}}</h4>
                <div class="text-right">
                    <a href="{{route('usr.edit', $user->id)}}" class="btn btn-success">Editar</a>
                    <a href="{{route('usr.delete', $user->id)}}" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
</div>
@stop