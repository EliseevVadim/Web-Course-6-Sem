<?php

namespace Lab3\AbstractShopPackage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lab3\AbstractShopPackage\Models\ProductStorage;
use Lab3\AbstractShopPackage\Models\Provider;

class ProductStorageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductStorage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'storage_name' => $this->faker->name,
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'storage_address' => $this->faker->address,
            'provider_id' => Provider::all()->random()->id
        ];
    }
}
