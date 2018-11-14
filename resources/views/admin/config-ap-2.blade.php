@extends('main')

@section('title', '| Configuração de Sistema')

@section('content')
    <h3>Preencha os números de apartamento de cada bloco. Ex: Todo bloco possui os apartamentos 1, 2, 3, 4, 5, 6.</h3>
    <form method="GET" action="{{ route('admin.config.ap.detail2') }}">
        @csrf
        <?php
        //Descobre quantidade de blocos
        $aps = $_GET['howmanytotal'] / $_GET['howmanyblock'];

            for ($i = 1; $i <= $_GET['howmanyblock']; $i++){
                echo "<input type=\"number\" name=\"ap_".$i."\" value=\"\"><br>";
            }
        ?>
         <input hidden type="number" name="howmanyblocks" value="<?= $aps ?>"><br>
         <input hidden type="number" name="howmanyblock" value="<?= $_GET['howmanyblock'] ?>"><br>
        <input type="submit" value="Logar"><br><br>
    </form>
@stop