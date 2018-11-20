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
        var html = '<input type="number" name="ap[]"><br>';
        addElement('files', 'p', 'file-' + fileId, html);
        }
    
</script>
@stop

@section('content')
    <h3>Preencha os números de apartamento de cada bloco. Ex: Todo bloco possui os apartamentos 1, 2, 3, 4, 5, 6.</h3>
    <form method="POST" action="{{ route('admin.config.ap.detail2') }}">
        @csrf
        <?php
            for ($i = 1; $i <= $pblocos; $i++){
                echo "<input type=\"number\" name=\"ap[]\" value=\"\"><br>";
            }
        ?>

        <div id="files">
        
        </div>

        <button type="button" onclick="addFile();">Adicionar Apartamento para este bloco</button><br>

        <input hidden type="number" name="pblocos" value="<?= $pblocos ?>"><br>
        <input hidden type="number" name="blocos" value="<?= $blocos ?>"><br>
        <input hidden type="number" name="total" value="<?= $total ?>"><br>
        <input type="submit" value="Logar"><br><br>
    </form>
@stop