@extends('main')

@section('title', '| Deletar Apartamento')

@section('content')
<h3>Deseja deletar {{$ap->bloco->prefix . "-" . $ap->apartamento}}?</h3>
    <form method="POST" action="{{ route('admin.config.destroy', $ap->id) }}">
        @csrf
        <input hidden type="text" name="_method" value="DELETE">
        <input type="submit" value="Sim">
    </form>
    <a href="{{route('admin.dashboard')}}">Não</a>
@stop