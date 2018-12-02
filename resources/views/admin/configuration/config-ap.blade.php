@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Configure a quantidade de apartamentos</h3>
                <form method="POST" action="{{ route('admin.config.ap.detail') }}">
                        @csrf
                        <div class="form-group">
                            <label>Quantos apartamentos há no condomínio?</label>
                            <input type="number" name="total" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Os apartamentos são divididos em quantos blocos?</label>
                            <input type="number" name="blocos" class="form-control">
                        </div>
                    
                        <input type="submit" value="Continuar" class="form-control btn btn-success">
                    </form>
            </div>
        </div>
</div>
@stop