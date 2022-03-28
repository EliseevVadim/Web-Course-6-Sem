<?php

namespace App\Http\Controllers;

use App\Facades\ShopServiceFacade;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function handler(Request $request)
    {
        return ShopServiceFacade::bot()->handler();
    }

    public function test()
    {
        ShopServiceFacade::bot()->reply(ShopServiceFacade::bot()->currentUser()->role_id);
    }
}
