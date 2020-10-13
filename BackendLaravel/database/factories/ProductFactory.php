<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
	    'name' => $this->faker->lastName,
	    'description' => $this->faker->sentence(3),
	    'price' => $this->faker->numberBetween(500,900),
	    'stock' => $this->faker->numberBetween(10,15),
	    'user_id' => function () {
		    return \App\User::all()->random();
	    },
    ];
});
