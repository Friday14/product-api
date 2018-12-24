<?php

use Faker\Generator as Faker;


$factory->define(\App\Domain\Products\Category::class, function (Faker $faker) {
    return [
        'name' => $faker->streetName,
        'description' => $faker->text(140),
    ];
});
