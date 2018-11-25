@extends('main')

@section('title', '| Cadastro de Morador')

@section('content')
<h3>Cadastre um novo Usuário</h3>
    <form method="POST" enctype="multipart/form-data" action="{{ route('morador.store') }}">
        @csrf
        <label>Nome</label>
        <input type="text" name="name"><br>
        <label>Sobrenome</label>
        <input type="text" name="surname"><br>
        <label>RG</label>
        <input type="text" name="rg"><br>
        <label>Data de Nascimento</label>
        <input type="date" name="birthdate"><br>
        <label>Bloco</label>
        <select name="bloco">
            @foreach($blocos as $bloco)
                <option value="{{$bloco->id}}">{{$bloco->prefix}}</option>
            @endforeach
        </select>
        <label>Apartamento</label>
        <select name="ap">
            @foreach($bloco->apartamentos as $apartamento)
                    <option value="{{$apartamento->apartamento}}">{{$apartamento->apartamento}}</option>
            @endforeach
        </select><br>
        <label>Foto</label>
        <input type="file" name="picture"><br>
        <input type="submit" value="Cadastrar">
    </form>
@stop