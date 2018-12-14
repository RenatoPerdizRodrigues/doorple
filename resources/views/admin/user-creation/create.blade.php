@extends('main')

@section('title', '| Cadastro de Usuário')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="forms border">
                <h3 class="text-center">Cadastre um novo Usuário</h3>
                    <form data-parsley-validate method="POST" action="{{ route('usr.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Senha <small> | Deve conter no mínimo 8 letras, um número e uma letra maiúscula</small></label>
                            <input type="password" name="password" required minlength="6" data-parsley-pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Confirme a senha</label>
                            <input type="password" name="password-confirmation" required minlength="6" data-parsley-pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*" class="form-control">
                        </div>                  
                        
                        <input type="submit" value="Cadastrar" class="form-control btn btn-success">
                    </form>
        </div>
    </div>
</div>
@stop