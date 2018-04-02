<?php

use App\Models\Payment\Gateway;
use Illuminate\Database\Seeder;

class PaymentGatewaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gateway::create([
            'name' => 'PagSeguro',
            'slug' => 'pagseguro'
        ]);
    }
}
