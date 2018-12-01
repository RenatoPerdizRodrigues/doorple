@extends('main')

@section('title', '| Deletar Visitante')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
                <div class="forms border  text-center">
                    <h3 class="text-center">Deseja cadastrar o novo visitante de RG {{$visitante->rg}}?</h3>
                    <form method="POST" action="{{ route('vst.destroy', $visitante->id) }}">
                            @csrf
                            <a href="{{route('vst.show', $visitante->id)}}" class="btn btn-warning">Não</a>
                            <input hidden type="text" name="_method" value="DELETE">
                            <input type="submit" class="btn btn-danger" value="Sim">
                        </form>
                        
                </div>
        </div>
</div>
@stop