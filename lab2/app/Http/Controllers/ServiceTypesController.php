<?php

namespace App\Http\Controllers;

use App\Facades\ShopServiceFacade;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Telegram\Bot\FileUpload\InputFile;

class ServiceTypesController extends Controller
{
    public function loadAllTypes()
    {
        $types = ServiceType::query()->select('id', 'type_name')->get();
        $keyboard = [];
        $index = 0;
        $temp = [];
        foreach ($types as $type) {
            $count = Service::where('type_id', $type->id)->count();
            $index++;
            array_push($temp, ["text" => "$type->type_name ($count)", "callback_data" => "/type $type->id"]);
            if ($index % 2 == 0 || $index == count($types)) {
                array_push($keyboard, $temp);
                $temp = [];
            }
        }
        ShopServiceFacade::bot()->inlineKeyboard("Выберите интересующую Вас категорию:", $keyboard);
    }

    public function getServicesList($message, $route)
    {
        $typeId = (int)explode(' ', $route)[1];
        $name = ServiceType::where('id', $typeId)->select('type_name')->first()->type_name;
        $servicesCount = Service::where('type_id', $typeId)->count();
        $services = Service::where('type_id', $typeId)->get();
        ShopServiceFacade::bot()->reply("Услуги из категории \"$name\":");
        foreach ($services as $service) {
            $price = $service->discount != null ? $service->price - ($service->price * $service->discount / 100) : $service->price;
            $path = InputFile::create(storage_path('app/public/images/'.$service->image_path));
            ShopServiceFacade::bot()->sendService($service, $path, [
                [
                    ["text" => "Добавить в коризину ($price ₽)", "callback_data" => "/addToCart $service->id"]
                ]
            ]);
        }
    }
}
