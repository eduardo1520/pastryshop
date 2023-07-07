<?php

use App\Models\Purchase;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run()
    {
        factory(Purchase::class, 30)->create();
    }
}
