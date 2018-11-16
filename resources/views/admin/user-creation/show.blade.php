@extends('main')

@section('title', '| Visualização de Usuário')

@section('content')
    <h3>{{$user->name}}</h3>
    <h4>{{$user->email}}</h4>
    <a href="{{route('usr.edit', $user->id)}}">Editar</a>
    <a href="{{route('usr.delete', $user->id)}}">Excluir</a>
@stop