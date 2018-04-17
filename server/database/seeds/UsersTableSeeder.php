<?php

use App\User;
use App\Customer;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Nicolas Huber',
            'email' => 'eu@nicolashuber.me',
            'password' => 'secret'
        ]);

        Customer::create([
            'cpf' => '03116048037',
            'phone' => '51997084519',
            'birthdate' => '1995-05-03',
            'user_id' => $user->id
        ]);

        $user = User::create([
            'name' => 'Rene Santos',
            'email' => 'renesantos@gmail.com',
            'password' => 'kijuhy'
        ]);

        Customer::create([
            'cpf' => '00649137086',
            'phone' => '51981762101',
            'birthdate' => '1983-09-10',
            'user_id' => $user->id
        ]);
		
		$user = User::create([
            'name' => 'Camila Julien Reginato',
            'email' => 'camila@partnersco.com.br',
            'password' => '210490'
        ]);

        Customer::create([
            'cpf' => '00011122233',
            'phone' => '51988884444',
            'birthdate' => '1990-04-21',
            'user_id' => $user->id
        ]);

		$user = User::create([
            'name' => 'Josion Ramos',
            'email' => 'josion@partnersco.com.br',
            'password' => 'josion001'
        ]);

        Customer::create([
            'cpf' => '00011122244',
            'phone' => '51988884444',
            'birthdate' => '1980-01-01',
            'user_id' => $user->id
        ]);
    }
}
