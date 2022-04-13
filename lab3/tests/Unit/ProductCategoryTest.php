<?php

namespace Lab3\AbstractShopPackage\Tests\Unit;

use Lab3\AbstractShopPackage\Models\ProductCategory;
use Lab3\AbstractShopPackage\Tests\TestCase;

class ProductCategoryTest extends TestCase
{
    public function testProductCategoriesPageOpening()
    {
        $response = $this->get('/productsCategories/all');
        $response->assertStatus(200);
        $response->assertSee('Все категории товаров');
    }

    public function testCanGetProductCategoryById()
    {
        $category = ProductCategory::factory()->create();
        $response = $this->get('/productsCategories/'.$category->id);
        $response->assertExactJson([
            'data' => [
                'id' => $category->id,
                'category_name' => $category->category_name,
                'created_at' => $category->created_at,
                'updated_at' => $category->updated_at
            ]
        ]);
    }

    public function testProductCategoryAddingPageOpening()
    {
        $response = $this->get('/openProductCategoryAdding');
        $response->assertStatus(200);
        $response->assertSee('Добавить категорию товаров');
        $response->assertDontSee('Редактировать информацию о категории товаров');
    }

    public function testCanCreateProductCategory()
    {
        $name = uniqid();
        $category = ProductCategory::factory()->make(['category_name' => $name]);
        $this->postJson(route('productCategory.store'), $category->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('product_categories', ['category_name' => $name]);
    }

    public function testProductCategoryEditingPageOpening()
    {
        $categoryId = ProductCategory::factory()->create()->id;
        $response = $this->get('/openProductCategoryEditing/'.$categoryId);
        $response->assertStatus(200)
            ->assertSee('Редактировать информацию о категории товаров')
            ->assertDontSee('Добавить категорию товаров');
    }

    public function testCanUpdateProductCategory()
    {
        $categoryForEditing = ProductCategory::factory()->create();
        $categoryForEditing->category_name = uniqid();
        $this->putJson(route('productCategory.update'), $categoryForEditing->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('product_categories', ['category_name' => $categoryForEditing['category_name']]);
    }

    public function testCanDeleteProductCategory()
    {
        $category = ProductCategory::factory()->create();
        $this->delete('/deleteProductCategory/'.$category->id);
        $this->assertDatabaseMissing('product_categories', ['id' => $category->id]);
    }
}
