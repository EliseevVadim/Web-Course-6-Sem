<?php

namespace App\Http\Controllers;

use App\Facades\ShopServiceFacade;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class OrdersController extends Controller
{
    public function addToCart($message, $route)
    {
        $id = (int)explode(' ', $route)[1];
        ShopServiceFacade::bot()->inlineKeyboard("Выберите число единиц выбранной услуги:",[
            [
                ["text" => "1", "callback_data" => "/choose 1 $id"],
                ["text" => "2", "callback_data" => "/choose 2 $id"],
            ],
            [
                ["text" => "3", "callback_data" => "/choose 3 $id"],
                ["text" => "4", "callback_data" => "/choose 4 $id"],
            ],
            [
                ["text" => "5", "callback_data" => "/choose 5 $id"],
            ]
        ]);
    }

    public function chooseQuantity($message, $route)
    {
        $data = explode(' ', $route);
        $id = $data[2];
        $quantity = $data[1];
        $serviceInfo = Service::where('id', $id)->select('name', 'price', 'discount')->first();;
        $sum = (new Order())->calculateSum($serviceInfo, $quantity);
        ShopServiceFacade::bot()->inlineKeyboard("Действительно ли Вы хотите заказать
<b>услугу:</b> $serviceInfo->name
<b>в количестве:</b> $quantity?
<b>Итоговая цена составит:</b> $sum ₽", [
            [
                ["text" => "Да (добавить в заказы)", "callback_data" => "/confirm $quantity $id"],
                ["text" => "Нет", "callback_data" => "/cancelOrdering"]
            ]
        ]);
    }

    public function cancelOrdering()
    {
        ShopServiceFacade::bot()->reply("Процедура заказа услуги отменена.")
            ->next("start");
    }

    public function confirmOrdering($message, $route)
    {
        $data = explode(' ', $route);
        $quantity = $data[1];
        $id = (int)$data[2];
        $serviceInfo = Service::where('id', $id)->select('name', 'price', 'discount')->first();
        $order = new Order;
        $order->user_id = ShopServiceFacade::bot()->currentUser()->id;
        $order->service_id = $id;
        $order->quantity = $quantity;
        $order->sum = $order->calculateSum($serviceInfo, $quantity);
        $order->save();
        ShopServiceFacade::bot()->reply("Заказ успешно оформлен. Оплатить его Вы сможете во вкладке \"Заказы\" пользовательского меню.")
            ->next("start");
    }

    public function listOrders($message)
    {
        $userId = ShopServiceFacade::bot()->currentUser()->id;
        $orders = Order::join('services', 'services.id', '=', 'orders.service_id')
                        ->where('orders.user_id', $userId)
                        ->where('orders.state_id', 1)
                        ->get(['orders.*', 'services.*']);
        foreach ($orders as $order) {
            ShopServiceFacade::bot()->replyInvoice($order->name, $order->description, [
                ["label" => "Количество единиц услуги - $order->quantity", "amount" => $order->sum * 100]
            ], "data");
        }
    }
}
