<?php

use Illuminate\Database\Seeder;
use App\Morador;
use App\Veiculo;
use App\Bloco;
use App\Config;

class MoradoresTableSeeder extends Seeder
{
    //Seeder para popular a tabela de moradores e veículo de morador
    public function run()
    {
        //Irá inserir de dois q uatro moradores por apartamento, para cada apartamento
        $configs = Config::where('id', 1)->first();
        $total = $configs->total;
        $blocos = $configs->howmanyblocks;

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

        //Para cada bloco, circula por todos os apartamentos daquele bloco
        for ($i = 1; $i <= $blocos; $i++){
            $bloco = Bloco::find($i);

            //Para cada apartamento, insere de um a quatro moradores
            foreach($bloco->apartamentos as $apartamento){
                $quantidade = rand(1, 4);
                for ($qt = 1; $qt <= $quantidade; $qt++){
                    Morador::insert([
                        'name' => $nomes[rand(1, 39)],
                        'surname' => $sobrenomes[rand(1, 20)],
                        'rg' => rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9),
                        'birthdate' => rand(1, 29) . '/' . rand(1, 12) . '/' . rand(1975, 1993),
                        'picture' => '1.jpg',
                        'apartamento_id' => $apartamento->id,
                        'bloco_id' => $i,
                    ]);

                    $morador = Morador::where([['apartamento_id', $apartamento->id], ['bloco_id', $i]])->first();

                    //Insere zero ou um veículo para este morador
                    $veiculos = rand(0, 2);
                    if($veiculos == 1){
                        Veiculo::insert([
                            'vehicle_model' => $tipos[rand(0, 1)],
                            'vehicle_license_plate' => chr(rand(65, 90)) . chr(rand(65, 90)) . chr(rand(65, 90)) . '-' . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9),
                            'morador_id' => $morador->id
                        ]);
                    }
                }
            }
        }
    }
}
