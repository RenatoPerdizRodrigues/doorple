<?php

use Illuminate\Database\Seeder;
use App\Config;
use App\Bloco;
use App\Apartamento;

//Seeder que cria as configurações do sistema e insere blocos e apartamentos
class ConfigTablesSeeder extends Seeder
{
    public function run()
    {
        //Insere 5 blocos e 30 apartamentos, ou seja, 6 por bloco.

        //Inserção de blocos e apartamentos dentro dos mesmos, usando ASCII para o prefixo e o incrementando ao final do loop
        $ascii = 65;
        for ($i = 1; $i <= 5; $i++){
            Bloco::insert([
                'id' => $i,
                'prefix' => chr($ascii)
            ]);

            for ($i2 = 1; $i2 <= 5; $i2++){
                Apartamento::insert([
                    'apartamento' => $i2,
                    'bloco_id' => $i
                ]);
            }
            $ascii++;
        }


        //Insere configuração básica
        Config::insert([
            'configured' => 1,
            'system_name' => 'Portaria',
            'howmanyblocks' => 5,
            'visitor_car' => 1,
            'car_time' => 45,
            'resident_registry' => 1
        ]);
    }
}
