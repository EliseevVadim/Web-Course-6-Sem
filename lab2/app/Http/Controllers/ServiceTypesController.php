<?php

namespace App\Http\Controllers;

use App\Facades\ShopServiceFacade;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\User;
use Illuminate\Http\Request;
use Telegram\Bot\FileUpload\InputFile;

class ServiceTypesController extends Controller
{
    private const RecordsPerPage = 5;
    public function loadAllTypes()
    {
        $keyboard = self::createServiceTypesKeyboard(false);
        ShopServiceFacade::bot()->inlineKeyboard("Выберите интересующую Вас категорию:", $keyboard);
    }

    public function getServicesList($message, $route)
    {
        $data = explode(' ', $route);
        $typeId = (int)$data[1];
        $page = (int)$data[2];
        $nextPage = $page + 1;
        $prevPage = $page - 1;
        $name = ServiceType::where('id', $typeId)->select('type_name')->first()->type_name;
        $servicesCount = Service::where('type_id', $typeId)->count();
        $services = Service::where('type_id', $typeId)
            ->take(self::RecordsPerPage)
            ->skip(self::RecordsPerPage * $page)
            ->get();
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
        if ($servicesCount > self::RecordsPerPage) {
            $pagesCount = ceil($servicesCount / self::RecordsPerPage);
            $navKeyboard = [
                $prevPage >= 0 ?
                [
                    ["text" => "Предыдущей", "callback_data" => "/type $typeId $prevPage"],
                ] : [],
                $nextPage < $pagesCount  ?
                [
                    ["text" => "Следующей", "callback_data" => "/type $typeId $nextPage"]
                ] : []
            ];
            $temp = [];
            for ($i = 0; $i < $pagesCount; $i++) {
                $actualNumber = $i + 1;
                array_push($temp, ["text" => $actualNumber, "callback_data" => "/type $typeId $i"]);
            }
            array_push($navKeyboard, $temp);
            ShopServiceFacade::bot()->inlineKeyboard("Перейти к странице:", $navKeyboard);
        }
    }

    public function prepareServicesListForRemoving($message)
    {
        $keyboard = self::createServiceTypesKeyboard(true);
        ShopServiceFacade::bot()->replyEditedMessage($message->message_id, "Выберите удаляемую услугу", $keyboard);
    }

    public function createServiceTypesKeyboard($forDeleting)
    {
        $types = ServiceType::query()->select('id', 'type_name')->get();
        $keyboard = [];
        $index = 0;
        $temp = [];
        foreach ($types as $type) {
            $count = Service::where('type_id', $type->id)->count();
            $index++;
            if ($forDeleting)
                array_push($temp, ["text" => "$type->type_name ($count)", "callback_data" => "/removeCategory $type->id"]);
            else
                array_push($temp, ["text" => "$type->type_name ($count)", "callback_data" => "/type $type->id 0"]);
            if ($index % 2 == 0 || $index == count($types)) {
                array_push($keyboard, $temp);
                $temp = [];
            }
        }
        return $keyboard;
    }

    public function removeCategory($message, $route)
    {
        try {
            $id = explode(' ', $route)[1];
            $name = ServiceType::where('id', $id)->select('type_name')->first();
            ShopServiceFacade::bot()->replyEditedMessage($message->message_id, "Вы действительно хотите удалить категорию услуг: $name->type_name", [
                [
                    ["text" => "Да", "callback_data" => "/acceptRemoving $id"],
                    ["text" => "Нет", "callback_data" => "/cancelRemoving"]
                ]
            ]);
        }
        catch (\Exception $exception) {
            ShopServiceFacade::bot()->reply($exception->getMessage());
        }
    }

    public function cancelRemoving()
    {
        ShopServiceFacade::bot()->reply("Удаление категории услуг отменено.")
            ->next("start");
    }

    public function acceptRemoving($message, $route)
    {
        $id = explode(' ', $route)[1];
        ServiceType::destroy($id);
        ShopServiceFacade::bot()->reply("Категория услуг успешно удалена")
            ->next("start");
        ShopServiceFacade::bot()->sendMessageToAllUsers("Категории услуг были обновлены. Введите /start для отображения изменений.");
    }
}
