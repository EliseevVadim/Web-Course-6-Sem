<?php

namespace Lab3\AbstractShopPackage\Tests\Unit;

use Lab3\AbstractShopPackage\Models\Client;
use Lab3\AbstractShopPackage\Tests\TestCase;

class ClientTest extends TestCase
{
    public function testClientsPageOpening()
    {
        $response = $this->get('/clients/all');
        $response->assertStatus(200);
        $response->assertSee('Все клиенты');
    }

    public function testCanGetClientById()
    {
        $client = Client::factory()->create();
        $response = $this->get('/clients/'.$client->id);
        $response->assertExactJson([
            'data' => [
                'id' => $client->id,
                'client_full_name' => $client->client_full_name,
                'INN' => $client->INN,
                'address' => $client->address,
                'phone' => $client->phone,
                'orders_count' => 0,
                'created_at' => $client->created_at,
                'updated_at' => $client->updated_at
            ]
        ]);
    }

    public function testClientAddingPageOpening()
    {
        $response = $this->get('/openClientAdding');
        $response->assertStatus(200);
        $response->assertSee('Добавить клиента');
        $response->assertDontSee('Редактировать информацию о клиенте');
    }

    public function testCanCreateClient()
    {
        $name = uniqid();
        $client = Client::factory()->make(['client_full_name' => $name]);
        $this->postJson(route('client.store'), $client->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('clients', ['client_full_name' => $name]);
    }

    public function testClientEditingPageOpening()
    {
        $clientId = Client::factory()->create()->id;
        $response = $this->get('/openClientEditing/'.$clientId);
        $response->assertStatus(200)
            ->assertSee('Редактировать информацию о клиенте')
            ->assertDontSee('Добавить клиента');
    }

    public function testCanUpdateClient()
    {
        $clientForEditing = Client::factory()->create();
        $clientForEditing->client_full_name = uniqid();
        $this->putJson(route('client.update'), $clientForEditing->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('clients', ['client_full_name' => $clientForEditing['client_full_name']]);
    }

    public function testCanDeleteClient()
    {
        $client = Client::factory()->create();
        $this->delete('/deleteClient/'.$client->id);
        $this->assertDatabaseMissing('clients', ['id' => $client->id]);
    }
}
