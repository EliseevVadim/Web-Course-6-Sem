<?php

namespace Lab3\AbstractShopPackage\Tests\Unit;

use Lab3\AbstractShopPackage\Models\Provider;
use Lab3\AbstractShopPackage\Tests\TestCase;

class ProviderTest extends TestCase
{
    public function testProviderPageOpening()
    {
        $response = $this->get('/providers/all');
        $response->assertStatus(200);
        $response->assertSee('Все поставщики');
    }

    public function testCanGetProviderById()
    {
        $provider = Provider::factory()->create();
        $response = $this->get('/providers/'.$provider->id);
        $response->assertExactJson([
            'data' => [
                'id' => $provider->id,
                'provider_name' => $provider->provider_name,
                'country' => $provider->country,
                'city' => $provider->city,
                'address' => $provider->address,
                'postal_code' => $provider->postal_code,
                'email' => $provider->email,
                'phone' => $provider->phone,
                'created_at' => $provider->created_at,
                'updated_at' => $provider->updated_at
            ]
        ]);
    }

    public function testProviderAddingPageOpening()
    {
        $response = $this->get('/openProviderAdding');
        $response->assertStatus(200);
        $response->assertSee('Добавить поставщика');
        $response->assertDontSee('Редактировать информацию о поставщике');
    }

    public function testCanCreateProvider()
    {
        $name = uniqid();
        $provider = Provider::factory()->make(['provider_name' => $name]);
        $this->postJson(route('provider.store'), $provider->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('providers', ['provider_name' => $name]);
    }

    public function testProviderEditingPageOpening()
    {
        $providerId = Provider::factory()->create()->id;
        $response = $this->get('/openProviderEditing/'.$providerId);
        $response->assertStatus(200)
            ->assertSee('Редактировать информацию о поставщике')
            ->assertDontSee('Добавить поставщика');
    }

    public function testCanUpdateProvider()
    {
        $providerForEditing = Provider::factory()->create();
        $providerForEditing->provider_name = uniqid();
        $this->putJson(route('provider.update'), $providerForEditing->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('providers', ['provider_name' => $providerForEditing['provider_name']]);
    }

    public function testCanDeleteProvider()
    {
        $provider = Provider::factory()->create();
        $this->delete('/deleteProvider/'.$provider->id);
        $this->assertDatabaseMissing('providers', ['id' => $provider->id]);
    }
}
