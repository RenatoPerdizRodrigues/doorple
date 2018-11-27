@extends('main')

@section('title', '| Cadastro de Administrador')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h2>{{$admin->name}}</h2>
                <h4>{{$admin->email}}</h4>
                <div class="text-right">
                    <button class="btn btn-success"><a href="{{route('adm.edit', $admin->id)}}">Editar</a></button>
                    <button class="btn btn-danger"><a href="{{route('admin.delete', $admin->id)}}">Excluir</a></button>
                </div>
            </div>
        </div>
</div>
@stop