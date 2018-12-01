@extends('main')

@section('title', '| Cadastro de Usuário')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
                <div class="forms border">
                    <h3 class="text-center">Cadastre um novo usuário?</h3>
                    <form method="POST" enctype="multipart/form-data" action="{{ route('vst.update', $visitante->id) }}">
                        @csrf
                        <!-- Visitante -->
                        <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="name" value="{{$visitante->name}}" class="form-control">
                        </div>
                        <div class="form-group">
                                <label>Sobrenome</label>
                                <input type="text" name="surname" value="{{$visitante->surname}}" class="form-control">
                        </div>
                        <div class="form-group">
                                <label>RG</label>
                                <input type="text" name="rg" value="{{$visitante->rg}}" class="form-control">
                        </div>
                        <div class="form-group">
                                <label>Data de Nascimento</label>
                                <input type="date" name="birthdate" value="{{$visitante->birthdate}}" class="form-control">
                        </div>
                        <div class="form-group">
                                <label>Foto</label>
                                <input type="file" name="picture" class="form-control-file">
                        </div>
                        <div class="form-group">
                            <!-- Carro -->
                            <h3>Visitante está visitando de carro?</h3>
                            <label>Modelo do Veículo</label>
                            <input type="text" name="vehicle_model" class="form-control" value="{{$visitante->vehicle_model ? $visitante->vehicle_model : "" }}">
                            <label>Placa do Veículo</label>
                            <input type="text" name="vehicle_license_plate" class="form-control" value="{{$visitante->vehicle_license_plate ? $visitante->vehicle_license_plate : "" }}">
                        </div>            
                        <input hidden name="_method" value="PUT">
                        <input type="submit" value="Editar Visitante" class="form-control btn btn-success">
                    </form>
                </div>
        </div>
</div>
@stop