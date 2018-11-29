@extends('main')

@section('title', '| Cadastro de Morador')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="forms border">
                <h3 class="text-center">Cadastre um novo Morador</h3>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('morador.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Nome</label>
                            <input type="text" name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Sobrenome</label>
                            <input type="text" name="surname" class="form-control">    
                        </div>
                        <div class="form-group">
                            <label>RG</label>
                            <input type="text" name="rg" class="form-control">    
                        </div>
                        <div class="form-group">
                            <label>Data de Nascimento</label>
                            <input type="date" name="birthdate" class="form-control">    
                        </div>
                        <div class="form-group">
                            <label>Bloco</label>
                            <select name="bloco" class="form-control">
                                @foreach($blocos as $bloco)
                                    <option value="{{$bloco->id}}" class="form-control">{{$bloco->prefix}}</option>
                                @endforeach
                            </select>    
                        </div>
                        <div class="form-group">
                            <label>Apartamento</label>
                            <select name="ap" class="form-control">
                                @foreach($bloco->apartamentos as $apartamento)
                                        <option value="{{$apartamento->apartamento}}" class="form-control">{{$apartamento->apartamento}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Foto</label>
                            <input type="file" name="picture" class="form-control-file">
                        </div>

                        <input type="submit" value="Cadastrar" class="form-control btn btn-success">
                    </form>
        </div>
    </div>
</div>
@stop