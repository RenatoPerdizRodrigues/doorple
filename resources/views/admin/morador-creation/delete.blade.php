@extends('main')

@section('title', '| Deletar Morador')

@section('content')
<h3>Deseja deletar {{$morador->name}}?</h3>
    <form method="POST" action="{{ route('morador.destroy', $morador->id) }}">
        @csrf
        <input hidden type="text" name="_method" value="DELETE">
        <input type="submit" value="Sim">
    </form>
    <a href="{{route('admin.dashboard')}}">Não</a>
@stop