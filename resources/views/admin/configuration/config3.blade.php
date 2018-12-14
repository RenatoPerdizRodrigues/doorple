@extends('main')

@section('title', '| Configuração de Sistema')

@section('js')
<script>

    function addElement(parentId, elementTag, elementId, html) {
        // Adds an element to the document
        var p = document.getElementById(parentId);
        var newElement = document.createElement(elementTag);
        newElement.setAttribute('id', elementId);
        newElement.innerHTML = html;
        p.appendChild(newElement);
    }
        fileId = 0;

        function addFile() {
        fileId++; // increment fileId to get a unique ID for the new element
        var html = '<input type="number" class=\"form-control\" name="ap[]">';
        addElement('files', 'p', 'file-' + fileId, html);
        }
    
</script>
@stop

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Preencha a identificação de todos os apartamentos do primeiro bloco. <h5>Ex: O bloco possui os apartamentos 1, 2, 3, 4 e 5.</h5></h3>
                <form data-parsley-validate method="POST" action="{{ route('admin.config3Post') }}">
                        @csrf
                        <div class="form-group">
                            <label>Apartamentos</label>
                            <?php
                                for ($i = 1; $i <= $pblocos; $i++){
                                    echo "<input type=\"text\" class=\"form-control\" name=\"ap[]\" value=\"\">";
                                }
                            ?>

                            <div id="files">
                        
                            </div>
                        </div>                 

                        <div class="form-group text-center">
                                <button type="button" class="btn btn-secondary" onclick="addFile();">Adicionar Apartamento</button>
                        </div>

                        <div class="form-group">
                            <label>O condomínio possui {{$blocos}} blocos similares a este. Caso queira alterar a quantidade de blocos, altere o campo abaixo.</label><small>Máximo 90</small>
                            <input type="text" class="form-control" name="blocos" placeholder="{{$blocos}}">
                        </div> 
                
                        <input hidden type="number" name="pblocos" value="<?= $pblocos ?>">
                        <input hidden type="number" name="blocosold" value="<?= $blocos ?>">
                        <input hidden type="number" name="total" value="<?= $total ?>">
                        <div class="text-center">
                            <a href="{{ route('admin.config2') }}" class="btn btn-warning">Voltar</a>
                            <input type="submit" value="Continuar" class="btn btn-success">
                        </div>
                </form>
            </div>
        </div>
</div>
@stop