@extends('main')

@section('title', '| Cadastro de Morador')

@section('js')
<script>
    //Converte o array de blocos para js
    var blocosJS = '<?php echo json_encode($blocos); ?>';
    var apartamentosJS = '<?php echo json_encode($apartamentos); ?>';

    //Função que muda dinamicamente o conteúdo do select de apartamentos com base no bloco
    $(document).ready(function() {
        $("#bloco").change(function() {
            //Valor do select de bloco
            var val = $(this).val();

            //Variável de contagem
            var i = 0;

            //Loop por cada bloco
            blocosJS.forEach(function(element){
                //Confere se é o bloco selecionado
                if (val == element.id) {

                    //Variável de options a serem acrescentadas
                    var options = [];

                    //Loop cada array de apartamento                     
                    apartamentosJS[i].forEach(function(elementAP){
                        options.push("<option value=" + elementAP.id + ">"+ elementAP.apartamento +"</option>");
                    });

                    //Acréscimo de todas as options necessárias na div 'apartamento'
                    $("#apartamento").html(options);
                }
                i++;
            });
        });
    });
</script>
@stop

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
                            <input type="text" name="birthdate" class="form-control" id="date" placeholder="DD/MM/YYYY">    
                        </div>
                        <div class="form-group">
                            <label>Bloco</label>
                            <select name="bloco" class="form-control" id="bloco">
                                @foreach($blocos as $bloco)
                                    <option value="{{$bloco->id}}" class="form-control">{{$bloco->prefix}}</option>
                                @endforeach
                            </select>    
                        </div>
                        <div class="form-group">
                            <label>Apartamento</label>
                            <select name="ap" class="form-control" id="apartamento">
                                @foreach($apartamentosBlocoInicial as $apartamento)
                                        <option value="{{$apartamento->id}}" class="form-control">{{$apartamento->apartamento}}</option>
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

@section('jsbody')
<script src="{{ asset('/js/jquery.mask.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#date').mask('00/00/0000')
    });
</script>
@stop