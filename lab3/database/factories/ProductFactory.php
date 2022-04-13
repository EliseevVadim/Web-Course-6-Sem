<?php

namespace Lab3\AbstractShopPackage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lab3\AbstractShopPackage\Models\Product;
use Lab3\AbstractShopPackage\Models\ProductCategory;
use Lab3\AbstractShopPackage\Models\Provider;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->unique()->name,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(0, 500000),
            'image_path' => $this->faker->imageUrl.'.jpg',
            'category_id' => ProductCategory::all()->random()->id,
            'provider_id' => Provider::all()->random()->id,
            'storage_id' => Provider::all()->random()->id
        ];
    }
}
