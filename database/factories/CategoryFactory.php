<?php


$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->word,
        'description' => $faker->sentence
    ];
});


