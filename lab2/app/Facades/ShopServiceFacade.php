<?php

namespace App\Facades;

use App\Core\TelegramBotHandler;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Facade;

class ShopServiceFacade extends Facade
{
    /**
     * @method static TelegramBotHandler bot()
     * @see Logger
     */
    protected static function getFacadeAccessor(): string
    {
        return 'shop.service';
    }
}
