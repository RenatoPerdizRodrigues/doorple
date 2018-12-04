<!-- Pàgina principal de administrador, a ser construída -->

@extends('main')

@section('title', '| Página Principal de Usuário')

@section('content')
@section('content')
<div class="row">
        @if(empty($config[0]))
            <p>Você tem configurações a fazer</p>
        @else
            <!--Caso hajam visitantes no dia, mostrar tabela de visitantes -->
            <div class="col-md-10 offset-md-1">
                    <div class="indexes">
                            <h4 class="text-left">Últimas visitas do Dia</h4>
                            @if(empty($visitas[0]))
                                Não houveram visitas no condomínio hoje
                            @else            
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>Visitante</th>
                                        <th>Apartamento</th>
                                        @if($configs[0]->visitor_car == 1)
                                        <th>Veículo</th>
                                        @endif
                                        <th>Horário de Entrada</th>

                                    </thead>
                                    <tbody >
                                        @foreach($visitas as $visita)
                                            <tr>
                                                <td>{{$visita->id}}</td> 
                                                <td>{{$visita->visitante->name . ' ' . $visita->visitante->surname}}</td>
                                                <td>{{$visita->bloco->prefix . '-' . $visita->apartamento->apartamento}}</td>
                                                @if($configs[0]->visitor_car == 1)
                                                <td>@if($visita->vehicle_license_plate && $visita->vehicle_model) {{$visita->vehicle_model . ' - ' . $visita->vehicle_license_plate}} @else Sem veículo @endif</td>
                                                @endif
                                                <td>{{$visita->created_at->format('d/m/Y | H:i:s')}}</td>
                                            </tr>
                                        @endforeach
                                    </body>
                                </table>
                                @endif
                            </div>
                    </div>
            </div>
        @endif
@stop
    <a href="{{route('adm.create')}}">Criar Admin</a><br>
    <a href="{{route('adm.index')}}">Consultar Admin</a><br><br>
    <a href="{{route('usr.create')}}">Criar Usuário</a><br>
    <a href="{{route('usr.index')}}">Consultar Usuário</a><br><br>
    <a href="{{route('morador.create')}}">Criar Morador</a><br>
    <a href="{{route('morador.index')}}">Consultar Morador</a><br><br>
    <a href="{{route('veiculo_morador.index')}}">Consultar Veículos</a><br><br>
    <a href="{{route('admin.config.index')}}">Consultar Apartamentos</a><br>
    <a href="{{route('admin.config.edit')}}">Editar Configuração</a><br><br>
    <a href="{{route('admin.logout')}}">Logout</a>
@stop