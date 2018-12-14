@extends('main')

@section('title', '| Encontre um Visitante')

@section('js')
<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>

<script>
    //Converte o array de blocos para js
    var blocosJS = <?php echo json_encode($blocos); ?>;
    var apartamentosJS = <?php echo json_encode($apartamentos); ?>;

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
                <h3 class="text-center">Cadastre uma visita</h3>
                <form data-parsley-validate method="POST" id="form" action="{{ route('vst.search.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label>Qual apartamento o visitante deseja visitar?</label>
                        <label>Bloco</label>
                        <select name="bloco" class="form-control" id="bloco" required>
                            @foreach($blocos as $bloco)
                                <option value="{{$bloco->id}}" class="form-control">{{$bloco->prefix}}</option>
                            @endforeach
                        </select>
                        <label>Apartamento</label>
                        <select name="apartamento" class="form-control" id="apartamento" required>
                            @foreach($apartamentosBlocoInicial as $apartamento)
                                    <option value="{{$apartamento->id}}" class="form-control">{{$apartamento->apartamento}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>RG: </label>
                        <input type="text" name="rg" id="rg" class="form-control text-uppercase" required>
                    </div>                    
                    
                    <input type="submit" value="Buscar" class="form-control btn btn-success">
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