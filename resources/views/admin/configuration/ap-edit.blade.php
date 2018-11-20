@extends('main')

@section('title', '| Editar Apartamento')

@section('content')
<h3>Editar  Apartamento</h3>
<form method="POST" action="{{route('admin.config.ap-update', $ap->id)}}">
    @csrf
    Bloco:
    <select name="bloco_id">
    @foreach($blocos as $bloco)
        <option value="{{$bloco->id}}" @if($ap->bloco_id == $bloco->id) selected @endif>{{$bloco->prefix}}</option>
    @endforeach
    </select><br>
    <label>Apartamento (não deve já existir no bloco): </label>
    <input type="text" name="apartamento" value={{$ap->apartamento}}>
    <input type="text" hidden name="_method" value="PUT"> 
    <input type="submit" value="Cadastrar">
</form><br>
@stop