@extends('main')

@section('title', '| Cadastro de Usuário')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
                <div class="forms border">
                    <h3 class="text-center">Cadastre um novo usuário?</h3>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('vst.store') }}">
                        @csrf
                        <!-- Visitante -->
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
                                <input type="text" name="rg" value="{{$rg}}" class="form-control">
                        </div>
                        <div class="form-group">
                                <label>Data de Nascimento</label>
                                <input type="date" name="birthdate" class="form-control">
                        </div>
                        <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="picture" class="form-control-file">
                        </div>
                        <input type="text" hidden name="bloco" value="{{$blocovisita}}">
                        <input type="text" hidden name="apartamento" value="{{$apartamentovisita}}">
                        <div class="form-group">
                            <!-- Carro -->
                            <h3>Visitante está visitando de carro?</h3>
                            <label>Modelo do Veículo</label>
                            <input type="text" name="vehicle_model" class="form-control">
                            <label>Placa do Veículo</label>
                            <input type="text" name="vehicle_license_plate" class="form-control">
                        </div>            
                        <input type="submit" value="Continuar visita" class="form-control btn btn-success">
                    </form>
                </div>
        </div>
</div>
@stop