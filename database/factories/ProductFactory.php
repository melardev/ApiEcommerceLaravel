<?php


$factory->define(App\Models\Product::class, function (Faker\Generator $faker) {

    $name = $faker->sentence;
    return [
        'name' => $name,
        'slug' => str_slug($name),
        'description' => implode($faker->sentences(3), '\n'),
        'publish_on' => $faker->dateTimeBetween($startDate = '-2 years', $endDate = '+1 month'),
        'stock' => $faker->numberBetween(0, 1000),
        'price' => $faker->numberBetween(150, 2000),
    ];
});