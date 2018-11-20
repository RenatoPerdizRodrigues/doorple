@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
<h3>Visualização de Apartamentos</h3>
<form method="POST" action="{{ route('admin.config.search.submit') }}">
        @csrf
        <label>Apartamento: </label>
        <input type="text" name="apartamento"><br>
        <input type="submit" value="Procurar">
    </form><br><br>
    @foreach($blocos as $bloco)
        @foreach($apartamentos as $apartamento)
            @if($apartamento->bloco_id == $bloco->id)
                <p>Apartamento: {{$apartamento->bloco->prefix . "-" . $apartamento->apartamento}}</p>
                <p>Moradores: </p>
                @if(count($apartamento->moradores) == 0)
                    Vazio
                @else
                    <ul>
                    @foreach($apartamento->moradores as $morador)
                        @if($morador->bloco_id == $bloco->id && $morador->apartamento_id == $apartamento->id)
                            <li><a href="{{route('morador.show', $morador->id)}}">{{$morador->name . " " . $morador->surname}}</a></li>
                        @endif
                    @endforeach
                    </ul>
                @endif
            @endif
        @endforeach
    @endforeach
@stop