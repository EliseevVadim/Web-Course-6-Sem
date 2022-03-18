<?php

use App\Facades\ShopServiceFacade;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ServiceTypesController;
use App\Models\Order;
use App\Models\ServiceType;

ShopServiceFacade::bot()
    ->addRoute("/start", function ($message) {
        $categories = ServiceType::all()->count();
        $id = ShopServiceFacade::bot()->currentUser()->id;
        $ordersNum = Order::where('user_id', $id)->count();
        ShopServiceFacade::bot()->replyKeyboard(
            "<b>Доброго времени суток!</b>\nВас приветствует бот-помощник автосервиса N. Для дальнейшей работы выберите один из предложенных ниже разделов:",
        [
            [
                ["text" => "Категории услуг ($categories)"]
            ],
            [
                ["text" => "Справка"]
            ],
            [
                ["text" => "Заказы ($ordersNum)"]
            ],
            ShopServiceFacade::bot()->currentUser()->role_id == 2 ? [
                ["text" => "Только для модераторов"]
            ] : []
        ]);
    }, "start");

ShopServiceFacade::bot()->addRoute("/Категории услуг ([()0-9]+)", [ServiceTypesController::class, "loadAllTypes"]);

ShopServiceFacade::bot()->addRoute("/Только для модераторов", function ($message) {
    ShopServiceFacade::bot()->inlineKeyboard("Выберите действие:", [
        [
            ["text" => "Добавить услугу", "url" => "http://127.0.0.1:8000/openServiceAdding"]
        ]
    ]);
});

ShopServiceFacade::bot()->addRoute("/type [()0-9]+ [()0-9]+", [ServiceTypesController::class, "getServicesList"]);

ShopServiceFacade::bot()->addRoute("/addToCart [()0-9]+", [OrdersController::class, "addToCart"]);

ShopServiceFacade::bot()->addRoute("/choose [()0-9]+ [()0-9]+", [OrdersController::class, "chooseQuantity"]);

ShopServiceFacade::bot()->addRoute("/cancelOrdering", [OrdersController::class, "cancelOrdering"]);

ShopServiceFacade::bot()->addRoute("/confirm [()0-9]+ [()0-9]+", [OrdersController::class, "confirmOrdering"]);

ShopServiceFacade::bot()->addRoute("/Заказы ([()0-9]+)", [OrdersController::class, "listOrders"]);
