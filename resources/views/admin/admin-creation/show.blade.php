@extends('main')

@section('title', '| Cadastro de Administrador')

@section('content')
    <h3>{{$admin->name}}</h3>
    <h4>{{$admin->email}}</h4>
    <a href="{{route('adm.edit', $admin->id)}}">Editar</a>
    <a href="{{route('admin.delete', $admin->id)}}">Excluir</a>
@stop