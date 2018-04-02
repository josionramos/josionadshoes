<?php

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

$factory->define(Address::class, function (Faker $faker) {
    return [
        'zipcode' => $faker->randomNumber(8),
        'street' => $faker->streetName,
        'number' => $faker->buildingNumber,
        'district' => 'Jardim do Cedro',
        'city_id' => 4838,
    ];
});
