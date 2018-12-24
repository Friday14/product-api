<?php

use Faker\Generator as Faker;


$factory->define(\App\Domain\Products\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->streetName,
        'description' => $faker->text(140),
        'price' => $faker->numberBetween(0, 200)
    ];
});
