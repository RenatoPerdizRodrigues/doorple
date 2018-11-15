@extends('main')

@section('title', '| Cadastro de Administrador')

@section('content')
<h3>Deseja deletar {{$admin->name}}?</h3>
    <form method="POST" action="{{ route('adm.destroy', $admin->id) }}">
        @csrf
        <input hidden type="text" name="_method" value="DELETE">
        <input type="submit" value="Sim">
    </form>
    <a href="{{route('admin.dashboard')}}">Não</a>
@stop