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

        function addFile(i) {
        fileId++; // increment fileId to get a unique ID for the new element
        var html = '<input type="text"  name="apartamento_' + i + '[]"><br>';
        div = "files_" + i;
        addElement(div, 'p', 'file-' + fileId, html);
        }
    
</script>
@stop

@section('content')
<h1>Terminamos de configurar as views das configurações! Agora precisamos trabalhar com o finishConfig para que ele trabalhe com o array de apartamentos!</h1>
    <h3>Conclua a configuração do sistema.</h3>
    <form method="POST" action="{{ route('admin.config.finish') }}">
        @csrf
        <!-- Loop de cada bloco -->
        @for($i = 1; $i <= $blocos; $i++)
            <!-- Loop de cada apartamento por bloco -->
            <label>Bloco</label>
            <input type="text" name="{{"prefix" . $i}}"><br>
                <div id="{{"files_" . $i}}">
                @for($k = 0; $k < count($apartamentos); $k++)
                    <input type="text" value="@if(array_key_exists($k, $apartamentos)){{$apartamentos[$k]}}@endif" name="{{"apartamento_" . $i . "[]"}}"><br>
                @endfor
                </div>
            <button type="button" onclick="{{"addFile($i);"}}">Adicionar Apartamento para este bloco</button><br>
            <br>
        @endfor
        <input hidden type="text" name="blocos" value="{{$blocos}}"><br>
        <input type="submit" value="Logar"><br><br>
    </form>
@stop