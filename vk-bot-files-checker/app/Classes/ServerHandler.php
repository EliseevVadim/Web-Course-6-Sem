<?php


namespace App\Classes;

use App\Jobs\DownloadFile;
use App\Jobs\ProcessFile;
use App\Models\UploadedDocument;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use VK\CallbackApi\Server\VKCallbackApiServerHandler;
use VK\Client\VKApiClient;

class ServerHandler extends VKCallbackApiServerHandler
{
    const SECRET = 'files_bot_secret';
    const GROUP_ID = 213175710;
    const CONFIRMATION_TOKEN = '13c9bf7f';

    protected $chatId;
    protected $text;

    private $messageInfo;

    private $allowedExtensions = ['pdf', 'docx'];

    function confirmation(int $group_id, ?string $secret)
    {
        Log::info(print_r($group_id, true));
        if ($secret === static::SECRET && $group_id === static::GROUP_ID) {
            echo static::CONFIRMATION_TOKEN;
        }
    }

    public function messageNew(int $group_id, ?string $secret, array $object)
    {
        set_time_limit(0);
        Log::info(print_r($object, true));
        $this->chatId = $object["peer_id"];
        $this->text = $object["text"];
        $this->messageInfo = $object;
        $this->processUserInfo();
        $arr = [
            [
                "key" => "начать",
                "func" => function () {
                    $this->sendMessageWithTutorialReference("Вас приветсвует бот, проверяющий оригинальность
                        текста в документе на основе алгоритма шинглов.\n
                        Для проверки документа необходимо отправить файл в формате pdf либо docx вместе с сообщением \"проверь\" (регистр не важен). После этого, дождитесь окончания процесса проверки, результат будет отправлен следующим сообщением.\n
                        Результат будет содержать процент оригинальности Вашего документа, наибольший процент совпадения с документами, находящимися в системе и имя документа, имеющего наиболее высокий процента совпадений с проверяемым.\n
                        Важно! Проверка будет осуществляться на основе загруженных ранее документов, так что не пытайтесь проверять один и тот же документ по нескольку раз, во избежание получения негативного результата в виде выского процента совпадения.");
                },
            ],
            [
                "key" => "справка",
                "func" => function() {
                    $this->sendMessage($this->chatId, "Для проверки документа необходимо отправить файл в формате pdf либо docx вместе с сообщением \"проверь\" (регистр не важен). После этого, дождитесь окончания процесса проверки, результат будет отправлен следующим сообщением.\n
                        Результат будет содержать процент оригинальности Вашего документа, наибольший процент совпадения с документами, находящимися в системе и имя документа, имеющего наиболее высокий процента совпадений с проверяемым.\n
                        Важно! Проверка будет осуществляться на основе загруженных ранее документов, так что не пытайтесь проверять один и тот же документ по нескольку раз, во избежание получения негативного результата в виде выского процента совпадения.");
                }
            ],
            [
                "key" => "проверь",
                "func" => function () {
                    $this->sendMessage($this->chatId, "Обрабатываем Ваш файл.");
                    $this->processDocumentComparison();
                },
            ]
        ];
        $is_found = false;
        foreach ($arr as $item) {
            $tmp = mb_strtolower($this->text);
            Log::info("$tmp =>");
            if (strpos($tmp, $item["key"]) !==false) {
                $item["func"]();
                $is_found = true;
                break;
            }
        }
        if (!$is_found)
            $this->sendMessage($this->chatId, "Я тебя не понимаю!(");
        unset($this->messageInfo);
        echo 'ok';
    }

    protected function sendMessage($chatId, $message)
    {
        $access_token = env("VK_SECRET_KEY");
        $vk = new VKApiClient();
        $vk->messages()->send($access_token, [
            'peer_id' => $chatId,
            'message' => $message,
            'random_id' => random_int(0, 10000000000),
        ]);
    }

    protected function sendMessageWithKeyboard($chatId, $message, $keyboard)
    {
        $access_token = env("VK_SECRET_KEY");
        $vk = new VKApiClient();
        $vk->messages()->send($access_token, [
            'peer_id' => $chatId,
            'message' => $message,
            'random_id' => random_int(0, 10000000000),
            'keyboard' => json_encode($keyboard)
        ]);
    }

    private function sendMessageWithTutorialReference($message)
    {
        $this->sendMessageWithKeyboard($this->chatId, $message, [
            'one_time' => false,
            "buttons"=>[
                [
                    [
                        "action"=>[
                            "type"=>"text",
                            "payload"=>"{\"button\":\"справка\"}",
                            "label"=>"Справка"
                        ],
                        "color"=>"positive"
                    ]
                ]
            ]
        ]);
    }

    private function processUserInfo()
    {
        try {
            $access_token = env("VK_SECRET_KEY");
            $vk = new VKApiClient('5.90');
            $userData = $vk->users()->get($access_token, [
                'user_ids' => [$this->chatId],
                'fields' => ['screen_name']
            ])[0];
            $user = User::where('vk_id', $userData['id'])->get()->first();
            if (is_null($user))
                User::create([
                    'first_name' => $userData['first_name'],
                    'last_name' => $userData['last_name'],
                    'screen_name' => $userData['screen_name'],
                    'vk_id' => $userData['id']
                ]);
        }
        catch (\Exception $exception) {
            $this->sendMessage($this->chatId, $exception->getMessage());
        }
    }

    private function processDocumentComparison()
    {
        try {
            $attachmentData = $this->messageInfo['attachments'];
            if (count($attachmentData) > 1 || count($attachmentData) === 0) {
                $this->sendMessageWithTutorialReference("Ошибка! Число вложений не должно превышать единицы и быть равным нулю. Нажмите \"Справка\", чтобы перечитать правила использования бота.");
                return;
            }
            $checkedAttachment = $attachmentData[0]->doc;
            if (!in_array($checkedAttachment->ext, $this->allowedExtensions)) {
                $this->sendMessageWithTutorialReference("Ошибка! Формат вложения не соответствует требованиям. Нажмите \"Справка\", чтобы перечитать правила использования бота.");
                return;
            }
            $processFileJob = new ProcessFile($checkedAttachment, $this->chatId);
            dispatch($processFileJob);
        }
        catch (\Exception $exception) {
            $this->sendMessageWithTutorialReference("Произошла ошибка обработки вложения. Прочитайте требования к отправляемым вложениям в разделе \"Справка\"");
        }
    }
}
