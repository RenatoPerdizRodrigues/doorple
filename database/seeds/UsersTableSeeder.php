<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Insere um usuário administrador no banco de dados
        User::insert([
            'name' => 'User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456')
        ]);
    }
}
