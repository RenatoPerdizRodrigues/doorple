@extends('main')

@section('title', '| Deletar Visitante')

@section('content')
<h3>Deseja deletar {{$visitante->name}}? Isso também deletará todas as visitas relacionadas ao visitante</h3>
    <form method="POST" action="{{ route('vst.destroy', $visitante->id) }}">
        @csrf
        <input hidden type="text" name="_method" value="DELETE">
        <input type="submit" value="Sim">
    </form>
    <a href="{{route('admin.dashboard')}}">Não</a>
@stop