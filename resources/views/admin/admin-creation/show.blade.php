@extends('main')

@section('title', '| Cadastro de Administrador')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Informações de Administrador</h3>
                <hr>
                <h4>{{$admin->name}}</h4>
                <h5>{{$admin->email}}</h5>
                <div class="text-right">
                    <a href="{{route('adm.edit', $admin->id)}}" class="btn btn-success">Editar</a>
                    <a href="{{route('admin.delete', $admin->id)}}" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
</div>
@stop