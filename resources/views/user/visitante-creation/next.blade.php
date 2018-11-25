@extends('main')

@section('title', '| Novo Visitante')

@section('content')

<h1>Deseja cadastrar o novo visitante de RG {{$rg}}?</h1><br>
    <a href="{{route('vst.create', [$rg, $blocovisita, $apartamentovisita]) }}">Cadastrar</a><br>
    <a href="{{route('vst.main')}}">Voltar</a>

@stop