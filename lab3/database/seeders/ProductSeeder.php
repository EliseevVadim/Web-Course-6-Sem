<?php

namespace Lab3\AbstractShopPackage\Database\Seeders;

use Illuminate\Database\Seeder;
use Lab3\AbstractShopPackage\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::factory()
            ->count(10)
            ->create();
    }
}
