@extends('main')

@section('title', '| Deletar Usuário')

@section('content')
<h3>Deseja deletar {{$user->name}}?</h3>
    <form method="POST" action="{{ route('usr.destroy', $user->id) }}">
        @csrf
        <input hidden type="text" name="_method" value="DELETE">
        <input type="submit" value="Sim">
    </form>
    <a href="{{route('admin.dashboard')}}">Não</a>
@stop