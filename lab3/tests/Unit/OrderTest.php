<?php

namespace Lab3\AbstractShopPackage\Tests\Unit;

use Lab3\AbstractShopPackage\Models\Order;
use Lab3\AbstractShopPackage\Tests\TestCase;

class OrderTest extends TestCase
{
    public function testOrdersPageOpening()
    {
        $response = $this->get('/orders/all');
        $response->assertStatus(200);
        $response->assertSee('Все заказы');
    }

    public function testCanGetOrderById()
    {
        $order = Order::factory()->create();
        $response = $this->get('/orders/'.$order->id);
        $response->assertExactJson([
            'data' => [
                'id' => $order->id,
                'client_id' => $order->client_id,
                'product_id' => $order->product_id,
                'quantity' => $order->quantity,
                'sum' => $order->sum,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at
            ]
        ]);
    }

    public function testOrderAddingPageOpening()
    {
        $response = $this->get('/openOrderAdding');
        $response->assertStatus(200);
        $response->assertSee('Добавить заказ');
        $response->assertDontSee('Редактировать информацию о заказе');
    }

    public function testCanCreateOrder()
    {
        $lastId = Order::all()->last()->id;
        $order = Order::factory()->make();
        $this->postJson(route('order.store'), $order->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('orders', ['id' => $lastId + 1]);
    }

    public function testOrderEditingPageOpening()
    {
        $orderId = Order::factory()->create()->id;
        $response = $this->get('/openOrderEditing/'.$orderId);
        $response->assertStatus(200)
            ->assertSee('Редактировать информацию о заказе')
            ->assertDontSee('Добавить заказ');
    }

    public function testCanUpdateOrder()
    {
        $orderForEditing = Order::factory()->create();
        $orderForEditing->quantity = 316;
        $this->putJson(route('order.update'), $orderForEditing->toArray())
            ->assertStatus(302);
        $this->assertDatabaseHas('orders', ['quantity' => $orderForEditing['quantity']]);
    }

    public function testCanDeleteOrder()
    {
        $order = Order::factory()->create();
        $this->delete('/deleteOrder/'.$order->id);
        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
    }
}
