<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
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

$factory->define(Product::class, function (Faker $faker) {
    return  [
        "name" => rtrim($faker->text($faker->numberBetween(5, 15)), "."),
        "manufacturer" => $faker->company,
        "weight" => $faker->randomFloat(2, 1, 100000),
        "price" => $faker->randomFloat(2, 1, 100000),
        "qte" => $faker->numberBetween(5, 105),
        "expireDate" => $faker->dateTimeThisYear,
    ];
});

$factory->state(App\User::class, 'relate', function ($faker) {
    return [
        'category_id' => function () {
            return factory(App\Category::class)->create()->id;
        }
    ];
});
