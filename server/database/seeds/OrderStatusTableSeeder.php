<?php

use App\Models\Order\Status;
use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'name' => 'Iniciado',
            'slug' => 'STARTED'
        ]);

        Status::create([
            'name' => 'Aguardando pagamento',
            'slug' => 'WAIT_PAYMENT'
        ]);

        Status::create([
            'name' => 'Em separação',
            'slug' => 'PACKAGING'
        ]);

        Status::create([
            'name' => 'Em transporte',
            'slug' => 'SHIPPED'
        ]);

        Status::create([
            'name' => 'Finalizado',
            'slug' => 'FINISHED'
        ]);
    }
}
