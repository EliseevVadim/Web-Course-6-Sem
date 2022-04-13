<?php

namespace Lab3\AbstractShopPackage\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lab3\AbstractShopPackage\Models\ProductCategory;

class ProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_name' => $this->faker->unique()->sentence
        ];
    }
}
