<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        //Chama os seeds criados
        $this->call(AdminsTableSeeder::class);
        //$this->call(ConfigTablesSeeder::class);
        //$this->call(UsersTableSeeder::class);
        //$this->call(MoradoresTableSeeder::class);
        //$this->call(VisitaTableSeeder::class);
        //$this->call(EntradasTableSeeder::class);
    }
}
