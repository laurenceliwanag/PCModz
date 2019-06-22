<?php

use Faker\Generator as Faker;

$factory->define(App\Products::class, function (Faker $faker) {
    return [
        'image' => "noimage.jpg",
        'name' => $faker->text(20),
        'description' => $faker->text(100),
        'category_id' => "1",
        'srp' => $faker->randomNumber(5),
        'stock' => "0",
        'critical' => "5",
        'status' => "1",
        'featured' => "0",
    ];
});
