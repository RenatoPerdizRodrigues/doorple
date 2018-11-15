@extends('main')

@section('title', '| Cadastro de Administrador')

@section('content')
<h3>Encontre um Admin</h3>
    <form method="POST" action="{{ route('adm.search.submit') }}">
        @csrf
        <label>Email do Adm</label>
        <input type="text" name="email"><br>
        <input type="submit" value="Procurar">
    </form><br><br>
    @foreach($admins as $admin)
        <p>{{$admin->name . "|" . $admin->email}}</p>
        <p><a href="{{route('adm.show', $admin->id)}}">Visualizar</a></p>
    @endforeach
@stop