@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
    <h3>Conclua a configuração do sistema.</h3>
    <form method="POST" action="{{ route('admin.config.finish') }}">
        @csrf
        <!-- Recebemos $ap_Y (onde I é $_GET['howmanyblock']), howmanytotal, howmanyblock, prefix, howmanyeachblock -->
        <!-- Loop para cada bloco -->
        <?php
            for ($i = 1; $i <= $_GET['howmanyblocks']; $i++){
                echo "Nome do bloco: <input type=\"text\" name=\"prefix_".$i."\"><br>";
                
                //Loop para cada apartamento de cada bloco
                for ($i2 = 1; $i2 <= $_GET['howmanyblock']; $i2++){
                    echo "<input type=\"number\" name=\"ap_".$i2."\" value=\"".$_GET['ap_'.$i2]."\"><br>";
                }
            }

            //Irá passar dentro da $request howmanyblock para o loop
            //Irá passar prefix_1 a prefix_y, onde Y é o valor de howmanyblock
            //Irá passar o ap_X  
        ?>
        <!--Quantidade de fors para loop-->
        <input hidden type="text" name="howmanyblock" value="{{ $_GET['howmanyblock'] }}">
        <input hidden type="text" name="howmanyblocks" value="{{ $_GET['howmanyblocks'] }}">
        <input type="submit" value="Logar"><br><br>
    </form>
@stop