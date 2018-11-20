@extends('main')

@section('title', '| Inserir Apartamento')

@section('content')
<h3>Inserir um Apartamento</h3>
<form method="POST" action="{{route('admin.config.store')}}">
    @csrf
    Bloco:
    <select name="bloco_id">
    @foreach($blocos as $bloco)
        <option value="{{$bloco->id}}">{{$bloco->prefix}}</option>
    @endforeach
    </select><br>
    <label>Apartamento (não deve já existir no bloco): </label>
    <input type="text" name="apartamento">
    <input type="submit" value="Cadastrar">
</form><br>
@stop