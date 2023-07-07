<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'date_birth' => $faker->date,
        'address' => $faker->address,
        'complement' => $faker->text(50),
        'neighborhood' => $faker->streetName,
        'cep' => $faker->postcode,
        'date_entry' => $faker->date
    ];
});
