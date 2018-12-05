@extends('main')

@section('title', '| Novo Visitante')

@section('content')
<div class="row">
    <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Deseja cadastrar o novo visitante de RG <input disabled type="text" class="rg_view text-center" id="rg" value="{{$rg . "aaaaaaa"}}"></h3>
                <hr>
                <div class="text-right">
                        <a href="{{route('vst.main')}}" class="btn btn-warning">Voltar</a>
                        <a href="{{route('vst.create', [$rg, $blocovisita, $apartamentovisita]) }}" class="btn btn-success">Cadastrar</a><br>
                        
                </div>
            </div>
    </div>
</div>
@stop

@section('jsbody')
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#rg').mask('99.999.999-W?', {
            translation: {
                'W' : {
                    pattern: /[Xx0-9]/
                }
            },
            reverse: true
        })
    });

    $("#form").submit(function() {
        $("#rg").unmask();
    });

</script>
@stop