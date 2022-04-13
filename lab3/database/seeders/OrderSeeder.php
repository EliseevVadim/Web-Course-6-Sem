<?php

namespace Lab3\AbstractShopPackage\Database\Seeders;

use Illuminate\Database\Seeder;
use Lab3\AbstractShopPackage\Models\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory()
            ->count(15)
            ->create();
    }
}
