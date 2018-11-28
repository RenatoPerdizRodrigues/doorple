@extends('main')

@section('title', '| Deletar Administrador')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Deseja deletar {{$admin->name}}?</h3>
                <div class="text-center inline-block">
                    <form method="POST" action="{{ route('adm.destroy', $admin->id) }}">
                        @csrf
                        <a href="{{route('admin.dashboard')}}" class="btn btn-warning">Voltar</a>
                        <input hidden type="text" name="_method" value="DELETE">
                        <input type="submit" class ="btn btn-danger" value="Sim">
                    </form>
                </div>
            </div>
        </div>
</div>
@stop