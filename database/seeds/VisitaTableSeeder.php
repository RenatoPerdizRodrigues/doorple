<?php

use Illuminate\Database\Seeder;
use App\Visita;
use App\Visitante;
use App\Morador;
use App\Apartamento;

class VisitaTableSeeder extends Seeder
{
    //Insere visitantes
    public function run()
    {
        //Array de nomes possíveis
        $nomes = array(
            'Alice', 'Miguel', 'Sophia', 'Arthur', 'Helena', 'Bernardo', 'Valentina', 'Heitor', 'Laura', 'Davi', 
            'Isabella', 'Lorenzo' , 'Manuela', 'Théo', 'Júlia', 'Pedro', 'Heloísa', 'Gabriel', 'Luiza', 'Enzo', 
            'Maria', 'Luiza', 'Matheus', 'Lorena', 'Lucas',	'Lívia', 'Benjamin', 'Giovanna', 'Nicolas',	'Maria',
            'Eduarda', 'Guilherme',	'Beatriz', 'Rafael', 'Maria Clara', 'Joaquim', 'Cecília', 'Samuel', 'Eloá', 'Renato'
        );


        $sobrenomes = array(
            'Peixe', 'Pinto', 'Rodrigues', 'Silva', 'Pereira', 'Santos', 'Oliveira', 'Souza', 'Ferreira', 'Alves',
            'Andrade', 'Barbosa', 'Barros', 'Queiroz', 'Lima', 'Araújo', 'Peixoto', 'Fogaça', 'Ramos', 'Teixeira', 'da Luz'
        );
        
        $tipos = array('Carro', 'Moto');

        //Insere 40 visitantes
        for ($i = 1; $i <= 40; $i++){
            Visitante::insert([
                'name' => $nomes[rand(1, 39)],
                'surname' => $sobrenomes[rand(1, 20)],
                'rg' => rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9),
                'birthdate' => rand(1, 29) . '/' . rand(1, 12) . '/' . rand(1975, 1993),
                'picture' => '1.jpg',
                'vehicle_model' => $tipos[rand(0, 1)],
                'vehicle_license_plate' => chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . '-' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9),
            ]);
        }

        //Insere de 10 a 25 visitas por dia, nos últimos três dias
        //Inserções de trẽs dias atrás
        $quantidade = rand(10, 25);
        for ($i = 1; $i <= $quantidade; $i++){
            $visitante = Visitante::all()->random();
            $apartamento = Apartamento::all()->random();
            $data = new DateTime();
            $data->sub(new DateInterval('P3D'));
            Visita::insert([
                'visitante_id' => $visitante->id,
                'apartamento_id' => $apartamento->id,
                'bloco_id' => $apartamento->bloco->id,
                'vehicle_license_plate' => $visitante->vehicle_license_plate,
                'vehicle_model' => $visitante->vehicle_model,
                'vehicle_parked' => 0,
                'created_at' => $data
            ]);    
        }

        //Inserções de dois dias atrás
        $quantidade = rand(10, 25);
        for ($i = 1; $i <= $quantidade; $i++){
            $visitante = Visitante::all()->random();
            $apartamento = Apartamento::all()->random();
            $data = new DateTime();
            $data->sub(new DateInterval('P2D'));
            Visita::insert([
                'visitante_id' => $visitante->id,
                'apartamento_id' => $apartamento->id,
                'bloco_id' => $apartamento->bloco->id,
                'vehicle_license_plate' => $visitante->vehicle_license_plate,
                'vehicle_model' => $visitante->vehicle_model,
                'vehicle_parked' => 0,
                'created_at' => $data
            ]);    
        }

        //Inserções de um dias atrás
        $quantidade = rand(10, 25);
        for ($i = 1; $i <= $quantidade; $i++){
            $visitante = Visitante::all()->random();
            $apartamento = Apartamento::all()->random();
            $data = new DateTime();
            $data->sub(new DateInterval('P1D'));
            Visita::insert([
                'visitante_id' => $visitante->id,
                'apartamento_id' => $apartamento->id,
                'bloco_id' => $apartamento->bloco->id,
                'vehicle_license_plate' => $visitante->vehicle_license_plate,
                'vehicle_model' => $visitante->vehicle_model,
                'vehicle_parked' => 0,
                'created_at' => $data
            ]);    
        }

        //Inserções do dia de hoje, que podem estar ou não com o veículo 
        $quantidade = rand(10, 25);
        for ($i = 1; $i <= $quantidade; $i++){
            $visitante = Visitante::all()->random();
            $apartamento = Apartamento::all()->random();
            $data = new DateTime();
            $data->sub(new DateInterval('PT' . rand(0, 74) . 'M'));
            //Decide se o visitante está com veículo ou não
            $veiculo = rand(0, 1);
            if($veiculo == 0){
                Visita::insert([
                    'visitante_id' => $visitante->id,
                    'apartamento_id' => $apartamento->id,
                    'bloco_id' => $apartamento->bloco->id,
                    'vehicle_license_plate' => $visitante->vehicle_license_plate,
                    'vehicle_model' => $visitante->vehicle_model,
                    'vehicle_parked' => 1,
                    'created_at' => $data
                ]);
            } elseif ($veiculo == 1){
                Visita::insert([
                    'visitante_id' => $visitante->id,
                    'apartamento_id' => $apartamento->id,
                    'bloco_id' => $apartamento->bloco->id,
                    'vehicle_license_plate' => null,
                    'vehicle_model' => null,
                    'vehicle_parked' => 0,
                    'created_at' => $data
                ]);
            }
            
        }

    }
}
