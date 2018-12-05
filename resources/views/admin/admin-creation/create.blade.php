@extends('main')

@section('title', '| Cadastro de Administrador')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="forms border">
                <h3 class="text-center">Cadastre um novo Admin</h3>
                <form method="POST" action="{{ route('adm.store') }}">
                    @csrf
                    <div class="form-group">
                        <label>Nome</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label>Senha<small> | Deve conter no mínimo 8 letras, um número e uma letra maiúscula</small></label>
                        <input type="password" class="form-control" name="password">
                    </div>
                    <div class="form-group">
                        <label>Confirme a senha</label>
                        <input type="password" class="form-control" name="password-confirmation">
                    </div>     
                    
                            <input type="submit" class="form-control btn btn-success" value="Cadastrar">
                </form>
        </div>        
    </div>
</div>
@stop