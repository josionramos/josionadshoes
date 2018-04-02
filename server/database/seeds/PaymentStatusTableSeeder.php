<?php

use App\Models\Payment\Status;
use Illuminate\Database\Seeder;

class PaymentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'name' => 'Aguardando pagamento',
            'code' => 1,
            'gateway_id' => 1
        ]);

        Status::create([
            'name' => 'Em análise',
            'code' => 2,
            'gateway_id' => 1
        ]);

        Status::create([
            'name' => 'Paga',
            'code' => 3,
            'gateway_id' => 1
        ]);

        Status::create([
            'name' => 'Disponível',
            'code' => 4,
            'gateway_id' => 1
        ]);

        Status::create([
            'name' => 'Em disputa',
            'code' => 5,
            'gateway_id' => 1
        ]);

        Status::create([
            'name' => 'Devolvida',
            'code' => 6,
            'gateway_id' => 1
        ]);

        Status::create([
            'name' => 'Cancelada',
            'code' => 7,
            'gateway_id' => 1
        ]);

        Status::create([
            'name' => 'Debitada',
            'code' => 8,
            'gateway_id' => 1
        ]);

        Status::create([
            'name' => 'Retenção temporária',
            'code' => 9,
            'gateway_id' => 1
        ]);
    }
}
