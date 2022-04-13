<?php

namespace Lab3\AbstractShopPackage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lab3\AbstractShopPackage\Models\Provider;

class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'provider_name' => $this->faker->unique()->name,
            'country' => $this->faker->country,
            'city' => $this->faker->city,
            'address' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber
        ];
    }
}
