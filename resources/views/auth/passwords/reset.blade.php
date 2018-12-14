@extends('main')

@section('title', '| Login de Usuário')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Resete sua Senha</h3>
                <form data-parsley-validate method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                                <label>E-mail:</label>
                                <input type="email" name="email" value="{{ $email ?? old('email') }}" required class="form-control">
                        </div>
                        <div class="form-group">
                                <label>Senha:</label>
                                <input type="password" name="password" required minlength="6" data-parsley-pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*" class="form-control">
                        </div>
                        <div class="form-group">
                                <label>Confirme a senha::</label>
                                <input type="password"name="password_confirmation" required minlength="6" data-parsley-pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*" class="form-control">
                        </div>
                        
                        <input type="submit" value="Logar" class="form-control btn btn-success">
                </form>
            </div>
        </div>
</div>
@stop