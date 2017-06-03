<?php

use Illuminate\Database\Seeder;

use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          User::Insert([
            ['name' => 'Test',
            'email' => 'email@gmail.com',
            'password' => 'testes'],
            ['name' => 'Test1',
            'email' => 'email1@gmail.com',
            'password' => 'testes'],
            ['name' => 'Test2',
            'email' => 'email2@gmail.com',
            'password' => 'testes'],
            ['name' => 'Test3',
            'email' => 'email3@gmail.com',
            'password' => 'testes'],
            ['name' => 'Test4',
            'email' => 'email4@gmail.com',
            'password' => 'testes'],
            ['name' => 'Test5',
            'email' => 'email5@gmail.com',
            'password' => 'testes'],
            ['name' => 'Test6',
            'email' => 'email6@gmail.com',
            'password' => 'testes'],
          ]);
    }
}
