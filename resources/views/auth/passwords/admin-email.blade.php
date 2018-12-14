@extends('main')

@section('title', '| Login de Usuário')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Digite seu e-mail de administrador</h3>
                <form data-parsley-validate method="POST" action="{{ route('admin.password.email') }}">
                        @csrf
                        <div class="form-group">
                                <label>E-mail:</label>
                                <input type="email"name="email" required class="form-control">
                        </div>
                        
                        <input type="submit" value="Logar" class="form-control btn btn-success">
                </form>
            </div>
        </div>
</div>
@stop