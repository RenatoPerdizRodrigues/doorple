@extends('main')

@section('title', '| Encontre um Visitante')

@section('content')
<form method="POST" action="{{ route('vst.search.submit') }}">
    @csrf
    <label>Qual apartamento o visitante deseja visitar?</label>
    <!-- Select de bloco -->
    <label>Bloco</label><br>
    <select name="bloco">
        @foreach($blocos as $bloco)
            <option value="{{$bloco->id}}">{{$bloco->prefix}}</option>
        @endforeach
    </select>
    <label>Apartamento</label>
    <select name="apartamento">
        @foreach($bloco->apartamentos as $apartamento)
                <option value="{{$apartamento->apartamento}}">{{$apartamento->apartamento}}</option>
        @endforeach
    </select><br><br>
    <label>RG: </label>
    <input type="text" name="rg"><br>
    <input type="submit" value="Buscar">
</form><br><br>

@stop