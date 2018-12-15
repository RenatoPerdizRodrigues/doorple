<?php

use Illuminate\Database\Seeder;
use App\Morador;
use App\EntradaMorador;

//Popula a tabela de entradas de morador
class EntradasTableSeeder extends Seeder
{
    public function run()
    {
        //Insere de 15 a 30 visitas por dia, nos últimos três dias
        //Inserções de trẽs dias atrás
        $quantidade = rand(15, 30);
        for ($i = 1; $i <= $quantidade; $i++){
            $morador = Morador::all()->random();
            
            //Decide se a entrada será com ou sem veículo
            $entrada = rand(0, 2);
            $veiculo = null;
            if ($entrada == 0 || $entrada == 2){
                if(!$morador->veiculos->isEmpty()){
                    $veiculo = $morador->veiculos->random();
                    $veiculo = $veiculo->id;
                }
            } elseif ($entrada == 1) {
                $veiculo = null;
            }

            $data = new DateTime();
            $data->sub(new DateInterval('P3D'));
            
            if ($veiculo != null){
                EntradaMorador::insert([
                    'morador_id' => $morador->id,
                    'veiculo_id' => $veiculo,
                    'created_at' => $data
                ]);
            } else {
                EntradaMorador::insert([
                    'morador_id' => $morador->id,
                    'created_at' => $data
                ]);
            }
        }

        //Inserções de dois dias atrás
        $quantidade = rand(15, 30);
        for ($i = 1; $i <= $quantidade; $i++){
            $morador = Morador::all()->random();
            
            //Decide se a entrada será com ou sem veículo
            $entrada = rand(0, 2);
            $veiculo = null;
            if ($entrada == 0 || $entrada == 2){
                if(!$morador->veiculos->isEmpty()){
                    $veiculo = $morador->veiculos->random();
                    $veiculo = $veiculo->id;
                }
            } elseif ($entrada == 1) {
                $veiculo = null;
            }

            $data = new DateTime();
            $data->sub(new DateInterval('P2D'));
            
            if ($veiculo != null){
                EntradaMorador::insert([
                    'morador_id' => $morador->id,
                    'veiculo_id' => $veiculo,
                    'created_at' => $data
                ]);
            } else {
                EntradaMorador::insert([
                    'morador_id' => $morador->id,
                    'created_at' => $data
                ]);
            }
        }

        //Inserções de um dias atrás
        $quantidade = rand(15, 30);
        for ($i = 1; $i <= $quantidade; $i++){
            $morador = Morador::all()->random();
            
            //Decide se a entrada será com ou sem veículo
            $entrada = rand(0, 2);
            $veiculo = null;
            if ($entrada == 0 || $entrada == 2){
                if(!$morador->veiculos->isEmpty()){
                    $veiculo = $morador->veiculos->random();
                    $veiculo = $veiculo->id;
                }
            } elseif ($entrada == 1) {
                $veiculo = null;
            }

            $data = new DateTime();
            $data->sub(new DateInterval('P1D'));
            
            if ($veiculo != null){
                EntradaMorador::insert([
                    'morador_id' => $morador->id,
                    'veiculo_id' => $veiculo,
                    'created_at' => $data
                ]);
            } else {
                EntradaMorador::insert([
                    'morador_id' => $morador->id,
                    'created_at' => $data
                ]);
            }
        }

        //Inserções de hoje
        $quantidade = rand(15, 30);
        for ($i = 1; $i <= $quantidade; $i++){
            $morador = Morador::all()->random();
            
            //Decide se a entrada será com ou sem veículo
            $entrada = rand(0, 2);
            $veiculo = null;
            if ($entrada == 0 || $entrada == 2){
                if(!$morador->veiculos->isEmpty()){
                    $veiculo = $morador->veiculos->random();
                    $veiculo = $veiculo->id;
                }
            } elseif ($entrada == 1) {
                $veiculo = null;
            }

            $data = new DateTime();
            
            if ($veiculo != null){
                EntradaMorador::insert([
                    'morador_id' => $morador->id,
                    'veiculo_id' => $veiculo,
                    'created_at' => $data
                ]);
            } else {
                EntradaMorador::insert([
                    'morador_id' => $morador->id,
                    'created_at' => $data
                ]);
            }
        }
    }
}
