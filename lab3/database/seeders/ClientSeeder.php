<?php

namespace Lab3\AbstractShopPackage\Database\Seeders;

use Illuminate\Database\Seeder;
use Lab3\AbstractShopPackage\Database\Factories\ClientFactory;
use Lab3\AbstractShopPackage\Models\Client;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::factory()
            ->count(10)
            ->create();
    }
}
