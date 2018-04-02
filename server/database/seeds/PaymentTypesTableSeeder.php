<?php

use App\Models\Payment\Type;
use Illuminate\Database\Seeder;

class PaymentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'name' => 'Boleto',
            'slug' => 'boleto',
            'code' => 1,
            'gateway_id' => 1
        ]);

        Type::create([
            'name' => 'Cartão de Crédito',
            'slug' => 'credit_card',
            'code' => 2,
            'gateway_id' => 1
        ]);
    }
}
