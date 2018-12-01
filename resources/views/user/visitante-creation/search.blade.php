@extends('main')

@section('title', '| Encontre um Visitante')

@section('content')
@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="forms border">
                <h3 class="text-center">Cadastre uma visita</h3>
                <form method="POST" action="{{ route('vst.search.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label>Qual apartamento o visitante deseja visitar?</label>
                        <label>Bloco</label>
                        <select name="bloco" class="form-control">
                            @foreach($blocos as $bloco)
                                <option value="{{$bloco->id}}" class="form-control">{{$bloco->prefix}}</option>
                            @endforeach
                        </select>
                        <label>Apartamento</label>
                        <select name="apartamento" class="form-control">
                            @foreach($bloco->apartamentos as $apartamento)
                                    <option value="{{$apartamento->apartamento}}" class="form-control">{{$apartamento->apartamento}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>RG: </label>
                        <input type="text" name="rg" class="form-control">
                    </div>
                    
                    
                    <input type="submit" value="Buscar" class="form-control btn btn-success">
                </form>
        </div>
    </div>
</div>
@stop