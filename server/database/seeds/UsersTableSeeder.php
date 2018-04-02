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
    }
}
