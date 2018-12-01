@extends('main')

@section('title', '| Cadastro de Entrada')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="forms border">
            <h3 class="text-center">Registro de entrada de morador</h3>
            <form method="POST" action="{{ route('entrada.confirm') }}">
                @csrf
                <!-- Visitante -->
                <div class="form-group">
                    <label>RG do morador</label>
                    <input type="text" name="rg" class="form-control">
                </div>
                
                <input type="submit" value="Encontrar Morador" class="form-control btn btn-success">
            </form>
        </div>
    </div>
</div>
    
@stop