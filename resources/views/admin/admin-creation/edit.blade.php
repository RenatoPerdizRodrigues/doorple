@extends('main')

@section('title', '| Edição de Administrador')

@section('content')
<div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="forms border">
                <h3 class="text-center">Editar Administrador</h3>
                <form data-parsley-validate method="POST" action="{{ route('adm.update', $admin->id) }}">
                @csrf
                <div class="form-group">
                    <label>Nome</label>
                    <input type="text" name="name" class="form-control" required value="{{$admin->name}}">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required value="{{$admin->email}}">
                </div>
                <div class="form-group">
                    <label>Senha<small> | Deve conter no mínimo 8 letras, um número e uma letra maiúscula</small></label>
                    <input type="password" id="password" name="password" minlength="6" data-parsley-pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*" class="form-control">
                </div>
                <div class="form-group">
                    <label>Confirme a senha</label>
                    <input type="password" name="password-confirmation" minlength="6" data-parsley-equalto="#password" class="form-control">
                </div>
                <input hidden type="text" name="_method" value="PUT">

                <input type="submit" class="form-control btn btn-success" value="Cadastrar">
    </form>
@stop