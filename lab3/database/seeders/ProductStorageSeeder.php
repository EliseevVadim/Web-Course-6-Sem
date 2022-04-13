<?php

namespace Lab3\AbstractShopPackage\Database\Seeders;

use Illuminate\Database\Seeder;
use Lab3\AbstractShopPackage\Models\ProductStorage;

class ProductStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductStorage::factory()
            ->count(10)
            ->create();
    }
}
