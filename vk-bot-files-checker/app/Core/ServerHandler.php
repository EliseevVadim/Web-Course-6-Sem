<?php

namespace App\Core;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use VK\CallbackApi\Server\VKCallbackApiServerHandler;
use VK\Client\VKApiClient;

class ServerHandler extends VKCallbackApiServerHandler
{
    const SECRET = "files_bot_secret";
    const GROUP_ID = 213175710;
    const CONFIRMATION_TOKEN = "63c762fd";

    protected $chatId;
    protected $text;

    private $messageInfo;

    private $allowedExtensions = ['doc', 'docx'];

    function confirmation(int $group_id, ?string $secret)
    {
        Log::info(print_r($group_id, true));
        if ($secret === static::SECRET && $group_id === static::GROUP_ID) {
            echo static::CONFIRMATION_TOKEN;
        }
    }

    public function messageNew(int $group_id, ?string $secret, array $object)
    {
        Log::info(json_encode($object));
        $this->chatId = $object["peer_id"];
        $this->text = $object["text"];
        $this->messageInfo = $object;
        $this->processUserInfo();
        $arr = [
            [
                "key" => "начать",
                "func" => function () {
                    $this->sendMessage($this->chatId, "Вас приветсвует бот, проверяющий оригинальность
                    текста в документе на основе алгоритма шинглов.\n
                    Для проверки документа необходимо отправить файл в формате doc либо docx вместе с сообщением \"проверь\" (регистр не важен). После этого, дождитесь окончания процесса проверки, результат будет отправлен следующим сообщением.\n
                    Важно! Проверка будет осуществляться на основе загруженных ранее документов, так что не пытайтесь проверять один и тот же документ по нескольку раз, во избежание получения негативного результата в виде выского процента совпадения.");
                },
            ],
            [
                "key" => "проверь",
                "func" => function() {
                    $this->processDocumentComparison();
                },
            ],
        ];
        $is_found = false;
        foreach ($arr as $item) {

            $tmp = mb_strtolower($this->text);

            Log::info("$tmp =>");
            if (strpos($tmp, $item["key"]) !==false) {
                $item["func"]();
                $is_found = true;
                //break;
            }
        }

        if (!$is_found)
            $this->sendMessage($this->chatId, "Я тебя не понимаю!(");

        //$this->sendMessageWithKeyboard($this->chatId,"Спасибо! Ваше сообщение: $this->text ");
        echo 'ok';
    }

    /**
     * @throws \VK\Exceptions\Api\VKApiMessagesPrivacyException
     * @throws \VK\Exceptions\Api\VKApiMessagesDenySendException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooLongMessageException
     * @throws \VK\Exceptions\Api\VKApiMessagesChatUserNoAccessException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooManyPostsException
     * @throws \VK\Exceptions\Api\VKApiMessagesChatBotFeatureException
     * @throws \VK\Exceptions\VKClientException
     * @throws \VK\Exceptions\Api\VKApiMessagesCantFwdException
     * @throws \VK\Exceptions\Api\VKApiMessagesUserBlockedException
     * @throws \VK\Exceptions\Api\VKApiMessagesKeyboardInvalidException
     * @throws \VK\Exceptions\VKApiException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooLongForwardsException
     * @throws \VK\Exceptions\Api\VKApiMessagesContactNotFoundException
     * @throws \Exception
     */
    protected function sendMessage($chatId, $message)
    {
        $access_token = env("VK_SECRET_KEY");
        $vk = new VKApiClient();
        $vk->messages()->send($access_token, [
            'peer_id' => $chatId,
            'message' => $message,
            'random_id' => random_int(0, 10000000000)
        ]);
    }

    /**
     * @throws \VK\Exceptions\Api\VKApiMessagesPrivacyException
     * @throws \VK\Exceptions\Api\VKApiMessagesDenySendException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooLongMessageException
     * @throws \VK\Exceptions\Api\VKApiMessagesChatUserNoAccessException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooManyPostsException
     * @throws \VK\Exceptions\Api\VKApiMessagesChatBotFeatureException
     * @throws \VK\Exceptions\VKClientException
     * @throws \VK\Exceptions\Api\VKApiMessagesCantFwdException
     * @throws \VK\Exceptions\Api\VKApiMessagesUserBlockedException
     * @throws \VK\Exceptions\VKApiException
     * @throws \VK\Exceptions\Api\VKApiMessagesKeyboardInvalidException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooLongForwardsException
     * @throws \VK\Exceptions\Api\VKApiMessagesContactNotFoundException
     * @throws \Exception
     */
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

    private function processUserInfo()
    {
        $access_token = env("VK_SECRET_KEY");
        $vk = new VKApiClient();
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

    /**
     * @throws \VK\Exceptions\Api\VKApiMessagesPrivacyException
     * @throws \VK\Exceptions\Api\VKApiMessagesDenySendException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooLongMessageException
     * @throws \VK\Exceptions\Api\VKApiMessagesChatUserNoAccessException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooManyPostsException
     * @throws \VK\Exceptions\Api\VKApiMessagesChatBotFeatureException
     * @throws \VK\Exceptions\VKClientException
     * @throws \VK\Exceptions\Api\VKApiMessagesCantFwdException
     * @throws \VK\Exceptions\Api\VKApiMessagesUserBlockedException
     * @throws \VK\Exceptions\Api\VKApiMessagesKeyboardInvalidException
     * @throws \VK\Exceptions\VKApiException
     * @throws \VK\Exceptions\Api\VKApiMessagesContactNotFoundException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooLongForwardsException
     */
    private function processDocumentComparison()
    {
        try {
            $attachmentData = $this->messageInfo['attachments'];
            if (count($attachmentData) > 1) {
                $this->sendErrorMessageWithTutorialReference("Ошибка! Число вложений не должно превышать единицы. Нажмите \"Справка\", чтобы перечитать правила использования бота.");
                return;
            }
            $checkedAttachment = $attachmentData[0]->doc;
            if (!in_array($checkedAttachment->ext, $this->allowedExtensions)) {
                $this->sendErrorMessageWithTutorialReference("Ошибка! Формат вложения не соответствует требованиям. Нажмите \"Справка\", чтобы перечитать правила использования бота.");
                return;
            }
            $fileName = $this->downloadFile($checkedAttachment->url, $checkedAttachment->title);
            $checker = new FileOriginalityChecker(3);
            $checker->checkOriginality($fileName);
            $this->sendMessage($this->chatId, "дуплюсь");
        }
        catch (\Exception $exception) {
            $this->sendMessage($this->chatId, $exception->getMessage());
            //$this->sendErrorMessageWithTutorialReference("Произошла ошибка обработки вложения. Прочитайте требования к отправляемым вложениям в разделе \"Справка\"");
        }
    }

    /**
     * @throws \VK\Exceptions\Api\VKApiMessagesDenySendException
     * @throws \VK\Exceptions\Api\VKApiMessagesPrivacyException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooLongMessageException
     * @throws \VK\Exceptions\Api\VKApiMessagesChatUserNoAccessException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooManyPostsException
     * @throws \VK\Exceptions\Api\VKApiMessagesChatBotFeatureException
     * @throws \VK\Exceptions\VKClientException
     * @throws \VK\Exceptions\Api\VKApiMessagesCantFwdException
     * @throws \VK\Exceptions\Api\VKApiMessagesUserBlockedException
     * @throws \VK\Exceptions\Api\VKApiMessagesKeyboardInvalidException
     * @throws \VK\Exceptions\VKApiException
     * @throws \VK\Exceptions\Api\VKApiMessagesTooLongForwardsException
     * @throws \VK\Exceptions\Api\VKApiMessagesContactNotFoundException
     */
    private function sendErrorMessageWithTutorialReference($message)
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

    private function downloadFile($url, $namePivot) : string
    {
        $fullName = uniqid() . '_' . str_replace(' ', '_', $namePivot);
        Storage::disk('uploads')->put($fullName, file_get_contents($url), 'public');
        return $fullName;
    }
}
