@extends('main')

@section('title', '| Deletar Morador')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="forms border text-center">
                <h3 class="text-center">Deseja deletar {{$morador->name}}?</h3>
                <form data-parsley-validate method="POST" action="{{ route('morador.destroy', $morador->id) }}">
                    @csrf
                    <a href="{{route('admin.dashboard')}}" class="btn btn-warning">Não</a>
                    <input hidden type="text" name="_method" value="DELETE">
                    <input type="submit" class="btn btn-danger" value="Sim">
                </form>
        </div>
    </div>
</div>    
@stop