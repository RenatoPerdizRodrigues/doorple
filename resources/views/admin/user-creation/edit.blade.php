@extends('main')

@section('title', '| Edição de Usuário')

@section('content')
<div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="forms border">
                    <h3 class="text-center">Edite um novo Usuário</h3>
                    <form data-parsley-validate method="POST" action="{{ route('usr.update', $user->id) }}">
                        @csrf
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control" value="{{$user->name}}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="{{$user->email}}">
                        </div>
                        <div class="form-group">
                            <label>Senha</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Confirme a senha</label>
                            <input type="password" name="password-confirmation" class="form-control">
                        </div>                     
                        
                        <input hidden type="text" name="_method" value="PUT">
                        <input type="submit" value="Cadastrar" class="form-control btn btn-success">
                    </form>
            </div>
        </div>
</div>
@stop