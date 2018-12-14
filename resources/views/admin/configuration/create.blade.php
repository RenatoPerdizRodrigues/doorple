@extends('main')

@section('title', '| Inserir Apartamento')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Cadastrar um Apartamento</h3>
                <form data-parsley-validate method="POST" action="{{route('admin.config.store')}}">
                        @csrf
                        <div class="form-group">
                            <label>Bloco</label>
                            <select name="bloco_id" class="form-control" required>
                                @foreach($blocos as $bloco)
                                    <option value="{{$bloco->id}}" class="form-control">{{$bloco->prefix}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Apartamento (não deve já existir no bloco): </label>
                            <input type="text" class="form-control" required name="apartamento">
                        </div>
    
                        <input type="submit" class="form-control btn btn-success" value="Cadastrar">
                </form>
            </div>
        </div>
</div>
@stop