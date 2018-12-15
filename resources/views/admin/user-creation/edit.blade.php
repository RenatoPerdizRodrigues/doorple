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
                            <input type="text" name="name" class="form-control" required @if(old('name')) value="{{old('name')}}" @else value="{{$user->name}}" @endif>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" required class="form-control" @if(old('email')) value="{{old('email')}}" @else value="{{$user->email}}" @endif>
                        </div>
                        <div class="form-group">
                            <label>Senha</label>
                            <input type="password" name="password" minlength="6" data-parsley-pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Confirme a senha</label>
                            <input type="password" name="password-confirmation" minlength="6" data-parsley-pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*" class="form-control">
                        </div>                     
                        
                        <input hidden type="text" name="_method" value="PUT">
                        <input type="submit" value="Cadastrar" class="form-control btn btn-success">
                    </form>
            </div>
        </div>
</div>
@stop