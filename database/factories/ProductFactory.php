<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    $pie = ['Frango e mussarela', 'Frango, tomate e mussarela',
        'Camarão com catupiry', 'Calabresa para pastel', 'Carne moída e mussarela',
        'Queijo com tomate e orégano', 'Pizza', 'Bauru'
    ];

    return [
        'name' => $pie[array_rand($pie)],
        'price' => $faker->randomFloat(2, 1,50),
        'photo' => trim(str_replace(" ", "_",$faker->text(15))) . "png"
    ];
});
