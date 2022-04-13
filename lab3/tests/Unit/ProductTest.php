<?php

namespace Lab3\AbstractShopPackage\Tests\Unit;

use Lab3\AbstractShopPackage\Models\Product;
use Lab3\AbstractShopPackage\Tests\TestCase;

class ProductTest extends TestCase
{
    public function testProductPageOpening()
    {
        $response = $this->get('/products/all');
        $response->assertStatus(200);
        $response->assertSee('Все товары');
    }

    public function testCanGetProductById()
    {
        $product = Product::factory()->create();
        $response = $this->get('/products/'.$product->id);
        $response->assertExactJson([
            'data' => [
                'id' => $product->id,
                'product_name' => $product->product_name,
                'description' => $product->description,
                'price' => $product->price,
                'image_path' => $product->image_path,
                'category_id' => $product->category_id,
                'provider_id' => $product->provider_id,
                'storage_id' => $product->storage_id,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at
            ]
        ]);
    }

    public function testProductAddingPageOpening()
    {
        $response = $this->get('/openProductAdding');
        $response->assertStatus(200);
        $response->assertSee('Добавить товар');
        $response->assertDontSee('Редактировать информацию о товаре');
    }

    public function testProductEditingPageOpening()
    {
        $productId = Product::factory()->create()->id;
        $response = $this->get('/openProductEditing/'.$productId);
        $response->assertStatus(200)
            ->assertSee('Редактировать информацию о товаре')
            ->assertDontSee('Добавить товар');
    }

    public function testCanUpdateProduct()
    {
        $productForEditing = Product::factory()->create();
        $productForEditing->product_name = uniqid();
        $productForEditing->image_path = null;
        $this->putJson(route('product.update'), $productForEditing->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('products', ['product_name' => $productForEditing['product_name']]);
    }

    public function testCanDeleteProduct()
    {
        $product = Product::factory()->create();
        $this->delete('/deleteProduct/'.$product->id);
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }
}
