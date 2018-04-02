<?php

use App\Models\Order\Order;
use App\Models\Order\Shipping;
use App\Models\Address\Address;

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Order::class, function (Faker $faker) {
    return [
        'reference' => Order::generateReference(),
        'status_id' => 1,
        'shipping_id' => function () {
            return factory(Shipping::class)->create()->id;
        },
    ];
});

$factory->define(Shipping::class, function (Faker $faker) {
    return [
        'price' => $faker->randomNumber(4),
        'address_id' => function () {
            return factory(Address::class)->create()->id;
        },
    ];
});
