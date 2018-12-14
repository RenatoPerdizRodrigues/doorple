@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Configure a quantidade de apartamentos</h3>
                <form data-parsley-validate method="POST" action="{{ route('admin.save.config2') }}">
                        @csrf
                        <div class="form-group">
                            <label>Quantos apartamentos há no condomínio?</label><small> Máximo 900</small>
                            <input type="number" name="total" required class="form-control" max="900" @if($configs->total != null) value="{{$configs->total}}" @else value="{{ old('total')}}" @endif>
                        </div>
                        <div class="form-group">
                            <label>Os apartamentos são divididos em quantos blocos?</label><small> Máximo 90</small>
                            <input type="number" name="blocos" required class="form-control" max="90" @if($configs->howmanyblocks != null) value="{{$configs->howmanyblocks}}" @else value="{{ old('blocos')}}" @endif>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('admin.config1') }}" class="btn btn-warning">Voltar</a>
                            <input type="submit" value="Continuar" class="btn btn-success">
                        </div>
                    </form>
            </div>
        </div>
</div>
@stop