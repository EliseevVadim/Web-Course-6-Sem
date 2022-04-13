<?php

namespace Lab3\AbstractShopPackage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lab3\AbstractShopPackage\Models\Client;
use Lab3\AbstractShopPackage\Models\Order;
use Lab3\AbstractShopPackage\Models\Product;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $product = Product::all()->random();
        $quantity = $this->faker->numberBetween(1, 20);
        return [
            'client_id' => Client::all()->random()->id,
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1, 20),
            'sum' => $product->price * $quantity
        ];
    }
}
