<!-- Pàgina principal de usuário, a ser construída -->
<!-- Nesta página, o Javascript se prepara para soltar uma notificação de acordo com a quatnidade de tempo restante para o carro no condomínio -->
<?php
    //Quantidade de segundos de espera antes que a notificação seja enviada
    $milisegundos = ($configs[0]->car_time * 60) * 1000;
?>

@extends('main')

@section('title', '| Página Principal de Usuário')

@section('js')
@stop

@section('content')
<div class="row">
        <!-- Caso hajam visitantes com veículos no condomínio, mostrar tabela de carros de visitantes -->
        <div class="col-md-10 offset-md-1">
            <div class="indexes">
                    <h4 class="text-left">Visitantes com veículo</h4>
                    @if(empty($carros[0]))
                        Não há visitantes com veículo no condomínio
                    @else
        
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Visitante</th>
                                <th>Apartamento</th>
                                <th>Veículo</th>
                                <th>Horário</th>
                                <th>Ações</th>
                            </thead>
                            <tbody >
                                @foreach($carros as $carro)
                                    <tr>
                                        <td>{{$carro->id}}</td> 
                                        <td>{{$carro->visitante->name . ' ' . $carro->visitante->surname}}</td>
                                        <td>{{$carro->bloco->prefix . '-' . $carro->apartamento->apartamento}}</td>
                                        <td>{{$carro->vehicle_model . ' - ' . $carro->vehicle_license_plate}}</td>
                                        <td>{{$carro->created_at}}</td>
                                        <td></td>
                                    </tr>
                                @endforeach
                            </body>
                        </table>
                        @endif
            </div>
        </div>
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
                                    <th>Veículo</th>
                                    <th>Horário de Entrada</th>

                                </thead>
                                <tbody >
                                    @foreach($visitas as $visita)
                                        <tr>
                                            <td>{{$visita->id}}</td> 
                                            <td>{{$visita->visitante->name . ' ' . $visita->visitante->surname}}</td>
                                            <td>{{$visita->bloco->prefix . '-' . $visita->apartamento->apartamento}}</td>
                                            <td>@if($visita->vehicle_license_plate && $visita->vehicle_model) {{$visita->vehicle_model . ' - ' . $visita->vehicle_license_plate}} @else Sem veículo @endif</td>
                                            <td>{{$visita->created_at}}</td>
                                        </tr>
                                    @endforeach
                                </body>
                            </table>
                            <div class="text-right">
                                    <a href="{{route('visita.index')}}" class="btn btn-success">Ver todas as visitas do dia</a>
                            </div>
                            @endif
                </div>
        </div>
</div>

<a href="{{route('vst.main')}}">Nova Visita</a><br>
<a href="{{route('visita.index')}}">Buscar Visitas</a><br>
<a href="{{route('vst.index')}}">Buscar Visitantes</a><br><br>
<a href="{{route('entrada.create')}}">Nova Entrada de Morador</a><br>
<a href="{{route('entrada.index')}}">Buscar Entradas</a><br>
@stop