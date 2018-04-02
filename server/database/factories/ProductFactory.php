<?php

use App\Models\Product\Product;
use App\Models\Product\Category;
use App\Models\Product\VariantValues;

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

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->word),
        'active' => true
    ];
});

$factory->define(Product::class, function (Faker $faker) {
    $name = trim($faker->sentence(6), '.');
    $price = $faker->randomNumber(4);

    return [
        'name' => $name,
        'title' => $name,
        'slug' => str_slug($name),
        'active' => true,
        'featured' => true,
        'price' => (int) round($price * 1.25),
        'price_sale' => $price,
        'category_id' => function () {
            return factory(Category::class)->create()->id;
        },
        'content' => $faker->text(200),
        'description' => $faker->text(150),
        'weight' => $faker->randomNumber(4),
        'width' => $faker->randomNumber(3),
        'height' => $faker->randomNumber(3),
        'length' => $faker->randomNumber(3)
    ];
});

$factory->define(VariantValues::class, function (Faker $faker) {
    return [
        'price' => $faker->randomNumber(4),
        'value' => ucfirst($faker->word),
        'extra' => $faker->hexcolor,
        'product_id' => function () {
            return factory(Product::class)->create()->id;
        },
        'variant_id' => 1
    ];
});
