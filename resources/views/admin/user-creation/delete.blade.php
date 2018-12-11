@extends('main')

@section('title', '| Deletar Usuário')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Deseja deletar {{$user->name}}?</h3>
                <div class="text-center inline-block">
                    <form data-parsley-validate method="POST" action="{{ route('usr.destroy', $user->id) }}">
                        @csrf
                        <a href="{{route('admin.dashboard')}}" class="btn btn-warning">Voltar</a>
                        <input hidden type="text" name="_method" value="DELETE">
                        <input type="submit" value="Sim" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>
</div>
@stop