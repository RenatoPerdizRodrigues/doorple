@extends('main')

@section('title', '| Editar Apartamento')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Editar Apartamento</h3>
                <form method="POST" action="{{route('admin.config.ap-update', $ap->id)}}">
                    @csrf
                    <div class="form-group">
                        <label>Bloco</label>
                        <select name="bloco_id" class="form-control">
                            @foreach($blocos as $bloco)
                                <option value="{{$bloco->id}}" class="form-control" @if($ap->bloco_id == $bloco->id) selected @endif>{{$bloco->prefix}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Apartamento</label>
                        <input type="text" name="apartamento" class="form-control" value={{$ap->apartamento}}>
                    </div>
                    
                    
                    <input type="text" hidden name="_method" value="PUT"> 
                    <input type="submit" class="form-control btn btn-success" value="Editar">
                </form>
            </div>
        </div>
</div>
@stop