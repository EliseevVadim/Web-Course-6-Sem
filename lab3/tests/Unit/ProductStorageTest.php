<?php

namespace Lab3\AbstractShopPackage\Tests\Unit;

use Lab3\AbstractShopPackage\Models\ProductStorage;
use Lab3\AbstractShopPackage\Tests\TestCase;

class ProductStorageTest extends TestCase
{
    public function testProductStoragesPageOpening()
    {
        $response = $this->get('/productsStorage/all');
        $response->assertStatus(200);
        $response->assertSee('Все склады');
    }

    public function testCanGetProductStorageById()
    {
        $storage = ProductStorage::factory()->create();
        $response = $this->get('/productsStorages/'.$storage->id);
        $response->assertExactJson([
            'data' => [
                'id' => $storage->id,
                'storage_name' => $storage->storage_name,
                'country' => $storage->country,
                'city' => $storage->city,
                'storage_address' => $storage->storage_address,
                'provider_id' => $storage->provider_id,
                'created_at' => $storage->created_at,
                'updated_at' => $storage->updated_at
            ]
        ]);
    }

    public function testProductStorageAddingPageOpening()
    {
        $response = $this->get('/openProductStorageAdding');
        $response->assertStatus(200);
        $response->assertSee('Добавить склад');
        $response->assertDontSee('Редактировать информацию о складе');
    }

    public function testCanCreateProductStorage()
    {
        $name = uniqid();
        $storage = ProductStorage::factory()->make(['storage_name' => $name]);
        $this->postJson(route('productStorage.store'), $storage->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('product_storages', ['storage_name' => $name]);
    }

    public function testProductStorageEditingPageOpening()
    {
        $storageId = ProductStorage::factory()->create()->id;
        $response = $this->get('/openProductStorageEditing/'.$storageId);
        $response->assertStatus(200)
            ->assertSee('Редактировать информацию о складе')
            ->assertDontSee('Добавить склад');
    }

    public function testCanUpdateProductStorage()
    {
        $storageForEditing = ProductStorage::all()->random();
        $storageForEditing->storage_name = uniqid();
        $this->putJson(route('productStorage.update'), $storageForEditing->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('product_storages', ['storage_name' => $storageForEditing['storage_name']]);
    }

    public function testCanDeleteProductStorage()
    {
        $storage = ProductStorage::factory()->create();
        $this->delete('/deleteProductStorage/'.$storage->id);
        $this->assertDatabaseMissing('product_storages', ['id' => $storage->id]);
    }
}
