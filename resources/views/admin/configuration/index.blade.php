@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
<div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="forms border">
                <h3 class="text-center">Selecione um Bloco</h3>
                    <form method="POST" action="{{ route('admin.config.search.submit') }}">
                        @csrf
                        <div class="form-group">
                            <label>Bloco</label>
                            <select name="bloco" class="form-control">
                                @foreach($blocos as $blocos)
                                    <option value="{{$blocos->prefix}}" @if($bloco[0]->prefix == $blocos->prefix) selected @endif>{{$blocos->prefix}}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="submit" value="Procurar" class="form-control btn btn-success">
                    </form>
            </div>
        </div>
        <div class="col-md-10 offset-md-1">
            <div class="indexes">
                    <h3>Lista de Apartamentos</h3>
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Apartamento</th>
                            <th>Moradores</th>
                            <th>Ações</th>
                        </thead>
                        <tbody >
                        @foreach($bloco as $bloco)
                            @foreach($apartamentos as $apartamento)
                                <tr>
                                    <td>{{$apartamento->id}}</td> 
                                    <td>{{$apartamento->bloco->prefix . "-" . $apartamento->apartamento}}</td>
                                    <td>
                                        @if(count($apartamento->moradores) == 0)
                                            Vazio
                                        @else
                                                @foreach($apartamento->moradores as $morador)
                                                    @if($morador->bloco_id == $bloco->id && $morador->apartamento_id == $apartamento->id)
                                                        <a href="{{route('morador.show', $morador->id)}}">{{$morador->name . " " . $morador->surname}}</a><br>
                                                    @endif
                                                @endforeach
                                        @endif
                                    </td>
                                    <td>
                                                    <a href="{{ route('admin.config.ap-edit', $apartamento->id) }}" class="btn btn-warning">Editar</a>
                                                    @if(count($apartamento->moradores) == 0)
                                                    <a href="{{ route('admin.config.delete', $apartamento->id) }}" class="btn btn-danger">Deletar</a>
                                                    @else 
                                                    <a href="#" class="btn btn-secondary">Deletar</a>
                                                    @endif
                                    </td>
                                <p></p> </li>
                                </tr>
                            @endforeach
                        @endforeach
                        </body>
                    </table>
            </div>
        </div>
</div>
@stop