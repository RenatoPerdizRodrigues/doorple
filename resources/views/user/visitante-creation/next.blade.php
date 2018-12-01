@extends('main')

@section('title', '| Novo Visitante')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Deseja cadastrar o novo visitante de RG {{$rg}}?</h3>
                <hr>
                <div class="text-right">
                        <a href="{{route('vst.main')}}" class="btn btn-warning">Voltar</a>
                        <a href="{{route('vst.create', [$rg, $blocovisita, $apartamentovisita]) }}" class="btn btn-success">Cadastrar</a><br>
                        
                </div>
            </div>
    </div>
</div>
@stop