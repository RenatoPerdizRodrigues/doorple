<!-- Pàgina principal de usuário, a ser construída -->
<!-- Nesta página, o Javascript se prepara para soltar uma notificação de acordo com a quatnidade de tempo restante para o carro no condomínio -->
<?php
    //Quantidade de segundos de espera antes que a notificação seja enviada
    $milisegundos = ($configs[0]->car_time * 60) * 1000;

    //Array de tempo restante de cada carro
    $data_entrada = array();

    //Contagem para inserção no array
    $i = 0;

    /*
    foreach($carros as $carro){
        //Pega a data do created_at, divide em um array
        $horaEntrada = explode(' ', $carro->created_at);
        $horaEntrada = $horaEntrada[1];
        $horaEntrada = new DateTime($horaEntrada);

        //Pega a hora atual
        $now = date("H:i:s");
        $now = new DateTime($now);

        //Calcula o intervalo entre quando o carro foi estacionado com o atual
        $interval = date_diff($horaEntrada, $now);

        //Tempo restante em minutos
        $timeLeft = $configs[0]->car_time - $interval->h;

        //Coloca o tempo restante no array
        array_push($data_entrada, $timeLeft);

    }*/

    foreach($carros as $carro){
        //Pega a hora de entrada do veículo no condomínio
        $horaEntrada = new DateTime($carro->created_at);
        $horario_saida = $horaEntrada->add(date_interval_create_from_date_string($configs[0]->car_time . ' minutes'));

        //Converte a timestamp para UNIX para passar para o JS
        $horario_saida = $horario_saida->format('Y-m-d H:i:s');
        $horario_saida = strtotime($horario_saida);

        //Coloca a timestamp do horário máximo de saída no array
        array_push($data_entrada, $horario_saida);

    }
    
    //Queremos passar a timestamp do cada carro

?>

@extends('main')

@section('title', '| Página Principal de Usuário')

@section('js')
<script>
    //Para cada div timer_, calcular o timer adequado

    //Converte o array de tempo restante para js
    var data_entradaJS = <?php echo json_encode($data_entrada); ?>;

    var i = 1;

    data_entradaJS.forEach(function(element){

        //Indica a div onde o timer será mostrado
        var name = 'timer_';
        var div = name.concat(i);

        //Indica a div que é a coluna da tabela onde o timer é mostrado
        var coluna = "tr_";
        var tr = coluna.concat(i);

        // Update the count down every 1 second
        var x = setInterval(function() {

            // Set the date we're counting down to
            date = new Date(element * 1000);


            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = date - now;

            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById(div).innerHTML = hours + "h "
            + minutes + "m " + seconds + "s ";

            // If the count down is finished, write some text 
            if (distance < 0) {
                document.getElementById(tr).style.color = "red";
                document.getElementById(div).innerHTML = "Tempo Expirado!";
            }
        }, 1000);


        i++;
    });

</script>
        
@stop

@section('content')
<div class="row">
    @if($configs[0]->visitor_car == 1)
        <!-- Caso hajam visitantes com veículos no condomínio, mostrar tabela de carros de visitantes -->
        <div class="col-md-12 offset-md-0">
            <div class="indexes">
                    <h4 class="text-left">Visitantes com veículo</h4>
                    @if(empty($carros[0]))
                        Não há visitantes com veículo no condomínio
                    @else
                        <?php $i = 1; ?>
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Visitante</th>
                                <th>Apartamento</th>
                                <th>Veículo</th>
                                <th>Horário de Entrada</th>
                                <th>Tempo restante</th>
                                <th>Ações</th>
                            </thead>
                            <tbody >
                                @foreach($carros as $carro)
                                    <tr id="{{'tr_'.$i}}">
                                        <td>{{$carro->id}}</td> 
                                        <td>{{$carro->visitante->name . ' ' . $carro->visitante->surname}}</td>
                                        <td>{{$carro->bloco->prefix . '-' . $carro->apartamento->apartamento}}</td>
                                        <td>{{$carro->vehicle_model . ' - ' . $carro->vehicle_license_plate}}</td>
                                        <td>{{$carro->created_at->format('d/m/Y | H:i:s')}}</td>
                                        <td id="{{'timer_'.$i}}"></td>
                                        <td><form method="POST" action="{{route('visita.leave')}}"> @csrf <input hidden type="text" name="id" value="{{$carro->id}}"><input type="submit" class="btn btn-danger" value="Registrar Saída"></form></td>
                                    </tr>
                                    <?php $i++; ?>
                                @endforeach
                            </body>
                        </table>
                        {{$carros->links()}}
                        @endif
            </div>
        </div>
    @endif
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
@stop