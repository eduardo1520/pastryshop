<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Client;
use App\Models\Product;
use App\Models\Purchase;
use Faker\Generator as Faker;

$factory->define(Purchase::class, function (Faker $faker) {

    $clientList = Client::select('id')->get()->toArray();
    $productList = Product::select('id')->get()->toArray();

    return [
        'client_id' => $clientList[array_rand($clientList)]['id'],
        'product_id' => $productList[array_rand($productList)]['id']
    ];
});
