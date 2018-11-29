<?php

use Illuminate\Database\Seeder;
use App\Morador;
use App\Veiculo;

class MoradoresTableSeeder extends Seeder
{
    //Seeder para popular a tabela de moradores e veículo de morador, com um morador, apenas para testes
    public function run()
    {
        Morador::insert([
            'name' => 'Fulano',
            'surname' => 'De Tal',
            'rg' => '12345678',
            'birthdate' => '07/06/1995',
            'picture' => '1.jpg',
            'apartamento_id' => 1,
            'bloco_id' => 1
        ]);        

        Veiculo::insert([
            'type' => 'Carro',
            'license_plate' => 'FHH-0000',
            'color' => 'Vermelho',
            'morador_id' => 1
        ]);
    }
}
