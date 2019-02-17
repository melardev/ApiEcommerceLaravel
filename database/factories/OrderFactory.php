<?php


use App\Models\Order;
use App\Models\User;

$factory->define(Order::class, function ($faker) {
    $address = \App\Models\Address::inRandomOrder()->first();
    return [
        'user_id' => $address->user ? $address->user->id : null,
        'address_id' => $address->id,
        // 'tracking_number' => $faker->lexify('???-????-????'),
        'tracking_number' => $faker->regexify('[0-9]{3}-[0-9]{4}-[0-9]{3}'),
        // To store order_status as string
        // 'order_status' => Order::status_choices[$this->faker->numberBetween(0, count(Order::status_choices) - 1)],
        // To store order_status as int
        'order_status' => $this->faker->numberBetween(0, count(Order::status_choices) - 1),
    ];
});