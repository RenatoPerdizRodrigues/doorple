@extends('main')

@section('title', '| Login de Usuário')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="forms border">
            <h3 class="text-center">Login de Usuário</h3>
            <form data-parsley-validate method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label>E-mail:</label>
                    <input type="email" required name="email" value="{{old('email')}}" class="form-control">
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" required name="password" class="form-control">
                </div>                
                
                <input type="submit" value="Logar" class="form-control btn btn-success">
                <div class="text-center">
                    <a href="{{route('password.request')}}">Esqueci minha senha</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop