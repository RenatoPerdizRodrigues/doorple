<?php

use Illuminate\Database\Seeder;
use App\Config;
use App\Apartamento;

class ConfigTablesSeeder extends Seeder
{
    public function run()
    {
        //Insere 30 apartamentos, divididos em 5 blocos de 6 apartamentos

        //Define o prefixo, começando do A
        $ascii = 65;        
        for ($i = 1; $i <= 5; $i++){
            for ($i2 = 1; $i2 <= 6; $i2++){
                Apartamento::insert([
                    'apartamento' => chr($asci)."-".$i2
                ]);
            }
            //Incrementa o ASCII do prefixo
            $ascii++;      
        }

        //Insere configuração básica
        Config::insert([
            'configured' => 1,
            'system_name' => 'Portaria',
            'visitor_car' => 0,
            'resident_registry' => 0
        ]);
    }
}
