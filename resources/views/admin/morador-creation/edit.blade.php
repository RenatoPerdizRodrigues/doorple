@extends('main')

@section('title', '| Edição de Morador')

@section('content')
<h3>Cadastre um novo Usuário</h3>
    <form method="POST" enctype="multipart/form-data" action="{{ route('morador.update', $morador->id) }}">
        @csrf
        <label>Nome</label>
        <input type="text" name="name" value="{{$morador->name}}"><br>
        <label>Sobrenome</label>
        <input type="text" name="surname" value="{{$morador->surname}}"><br>
        <label>RG</label>
        <input type="text" name="rg" value="{{$morador->rg}}"><br>
        <label>Data de Nascimento</label>
        <input type="date" name="birthdate" value="{{$morador->birthdate}}"><br>
        <label>Apartamento</label>
        <input type="text" name="ap" value="{{$morador->apartamento->apartamento}}"><br>
        <input type="file" name="picture" ><br>
        <input hidden name="_method" value="PUT">
        <input type="submit" value="Cadastrar">
    </form>
@stop