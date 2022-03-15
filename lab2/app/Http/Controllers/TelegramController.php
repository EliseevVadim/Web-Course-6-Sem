<?php

namespace App\Http\Controllers;

use App\Facades\ShopServiceFacade;
use Illuminate\Http\Request;

class TelegramController extends Controller
{
    public function handler(Request $request)
    {
        ShopServiceFacade::bot()->handle();
    }
}
