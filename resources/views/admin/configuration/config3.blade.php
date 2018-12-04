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
                <h3 class="text-center">Preencha os números de apartamento de um bloco. <h5>Ex: Todo bloco possui os apartamentos 1, 2, 3, 4, 5, 6.</h5></h3>
                <form method="POST" action="{{ route('admin.config3') }}">
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
                
                        <input hidden type="number" name="pblocos" value="<?= $pblocos ?>">
                        <input hidden type="number" name="blocos" value="<?= $blocos ?>">
                        <input hidden type="number" name="total" value="<?= $total ?>">
                        <input type="text" hidden name="system_name" value="{{$system_name}}">
                        <input type="text" hidden name="visitor_car" value="{{$visitor_car}}">
                        <input type="text" hidden name="resident_registry" value="{{$resident_registry}}">
                        <input type="text" hidden name="time" value="{{$time}}">
                        <input type="submit" value="Continuar" class="form-control btn btn-success">
                </form>
            </div>
        </div>
</div>
@stop