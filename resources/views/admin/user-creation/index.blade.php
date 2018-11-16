@extends('main')

@section('title', '| Index de Usuário')

@section('content')
<h3>Encontre um Usuário</h3>
    <form method="POST" action="{{ route('usr.search.submit') }}">
        @csrf
        <label>Email do User</label>
        <input type="text" name="email"><br>
        <input type="submit" value="Procurar">
    </form><br><br>
    @foreach($users as $user)
        <p>{{$user->name . "|" . $user->email}}</p>
        <p><a href="{{route('usr.show', $user->id)}}">Visualizar</a></p>
    @endforeach
@stop