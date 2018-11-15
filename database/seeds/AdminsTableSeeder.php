<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminsTableSeeder extends Seeder
{
    public function run()
    {
        //Insere um usuário administrador no banco de dados
        Admin::insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456')
        ]);
    }
}
