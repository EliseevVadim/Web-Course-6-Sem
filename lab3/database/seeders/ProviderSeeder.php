<?php

namespace Lab3\AbstractShopPackage\Database\Seeders;

use Illuminate\Database\Seeder;
use Lab3\AbstractShopPackage\Models\Provider;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Provider::factory()
            ->count(10)
            ->create();
    }
}
