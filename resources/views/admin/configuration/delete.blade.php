@extends('main')

@section('title', '| Deletar Apartamento')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Deseja deletar {{$ap->bloco->prefix . "-" . $ap->apartamento}}?</h3>
                <div class="text-center inline-block">
                        <form method="POST" action="{{ route('admin.config.destroy', $ap->id) }}">
                                @csrf
                                <input hidden type="text" name="_method" value="DELETE">
                                <a href="{{route('admin.dashboard')}}" class="btn btn-warning">Não</a>
                                <input type="submit" class="btn btn-danger" value="Sim">
                        </form>
                </div>
            </div>
        </div>
</div>
@stop