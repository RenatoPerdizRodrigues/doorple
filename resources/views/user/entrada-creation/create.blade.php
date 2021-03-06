@extends('main')

@section('title', '| Cadastro de Entrada')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
        <div class="forms border">
            <h3 class="text-center">Registro de entrada de morador</h3>
            <form data-parsley-validate method="POST" id="form" action="{{ route('entrada.confirm') }}">
                @csrf
                <div class="form-group">
                    <label>RG do morador</label>
                    <input type="text" name="rg" id="rg" class="form-control text-uppercase" required>
                </div>
                
                <input type="submit" value="Encontrar Morador" class="form-control btn btn-success">
            </form>
        </div>
    </div>
</div>
    
@stop

@section('jsbody')
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#rg').mask('99.999.999-W', {
            translation: {
                'W' : {
                    pattern: /[Xx0-9]/
                }
            },
            reverse: true
        })
    });

    $("#form").submit(function() {
        if ($(this).parsley().isValid()) {
            $("#rg").unmask();
        }
    });

</script>
@stop