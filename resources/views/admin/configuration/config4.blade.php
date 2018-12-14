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
        var html = '<input type="text" class="form-control" name="apartamento_' + i + '[]">';
        div = "files_" + i;
        addElement(div, 'p', 'file-' + fileId, html);
        }
    
</script>
@stop

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Conclua a configuração do sistema!<h5 class="text-center">Adicione apartamentos para cada bloco, ou deixe um apartamento em branco caso não exista naquele bloco.</h5></h3>
                <form data-parsley-validate method="POST" action="{{ route('admin.save.config3') }}">
                        @csrf
                        <!-- Loop de cada bloco -->
                        @for($i = 1; $i <= $blocos; $i++)
                            <div class="form group">
                                <!-- Loop de cada apartamento por bloco -->
                                <div class="forms border">
                                    <div class="form-group">
                                        <div class="text-center">
                                            <h4>Bloco {{$i}}</h4>
                                        </div>
                                        <label>Nome do Bloco</label>
                                        <input type="text" name="{{"prefix" . $i}}" class="form-control" placeholder="Bloco {{$i}}">
                                    </div>
                                    
                                    <div id="{{"files_" . $i}}" class="form-group">
                                        <label>Apartamentos do Bloco</label>
                                        @for($k = 0; $k < count($apartamentos); $k++)
                                            <input type="text" class="form-control" value="@if(array_key_exists($k, $apartamentos)){{$apartamentos[$k]}}@endif" name="{{"apartamento_" . $i . "[]"}}">
                                        @endfor
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="button" class="btn btn-secondary" onclick="{{"addFile($i);"}}">Adicionar Apartamento para este bloco</button>
                                    </div>
                                </div>
                            </div>
                        @endfor
                        <input hidden type="text" name="blocos" value="{{$blocos}}">
                        <input type="text" hidden name="pblocos" value="{{$pblocos}}">
                        <input type="submit" class="form-control btn btn-success" value="Terminar Configuração">
                </form>
            </div>
        </div>
</div>
@stop