<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(GalleriesTableSeeder::class);

        // Adddress
        $this->call(StatesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);

        // Products
        $this->call(ProductVariantTypesTableSeeder::class);

        // Orders
        $this->call(OrderStatusTableSeeder::class);

        // Payments
        $this->call(PaymentGatewaysTableSeeder::class);
        $this->call(PaymentStatusTableSeeder::class);
        $this->call(PaymentTypesTableSeeder::class);
    }
}
