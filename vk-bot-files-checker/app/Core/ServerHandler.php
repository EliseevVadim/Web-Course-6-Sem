<?php

namespace App\Core;

use App\Models\UploadedDocument;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use VK\CallbackApi\Server\VKCallbackApiServerHandler;
use VK\Client\VKApiClient;
use VK\Exceptions\Api\VKApiMessagesCantFwdException;
use VK\Exceptions\Api\VKApiMessagesChatBotFeatureException;
use VK\Exceptions\Api\VKApiMessagesChatUserNoAccessException;
use VK\Exceptions\Api\VKApiMessagesContactNotFoundException;
use VK\Exceptions\Api\VKApiMessagesDenySendException;
use VK\Exceptions\Api\VKApiMessagesKeyboardInvalidException;
use VK\Exceptions\Api\VKApiMessagesPrivacyException;
use VK\Exceptions\Api\VKApiMessagesTooLongForwardsException;
use VK\Exceptions\Api\VKApiMessagesTooLongMessageException;
use VK\Exceptions\Api\VKApiMessagesTooManyPostsException;
use VK\Exceptions\Api\VKApiMessagesUserBlockedException;
use VK\Exceptions\VKApiException;
use VK\Exceptions\VKClientException;

class ServerHandler extends VKCallbackApiServerHandler
{
    const SECRET = "files_bot_secret";
    const GROUP_ID = 213175710;
    const CONFIRMATION_TOKEN = "cc7aa99e";

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

    /**
     * @throws VKApiMessagesDenySendException
     * @throws VKApiMessagesPrivacyException
     * @throws VKApiMessagesTooLongMessageException
     * @throws VKApiMessagesChatUserNoAccessException
     * @throws VKApiMessagesTooManyPostsException
     * @throws VKApiMessagesChatBotFeatureException
     * @throws VKClientException
     * @throws VKApiMessagesCantFwdException
     * @throws VKApiMessagesUserBlockedException
     * @throws VKApiMessagesKeyboardInvalidException
     * @throws VKApiException
     * @throws VKApiMessagesTooLongForwardsException
     * @throws VKApiMessagesContactNotFoundException
     */
    public function messageNew(int $group_id, ?string $secret, array $object)
    {
        try {
            set_time_limit(0);
            Log::info(json_encode($object));
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
                    "func" => function() {
                        $this->processDocumentComparison();
                    },
                ],
            ];
            foreach ($arr as $item) {
                $tmp = mb_strtolower($this->text);
                Log::info("$tmp =>");
                if (strpos($tmp, $item["key"]) !==false) {
                    $item["func"]();
                    return;
                }
            }
            $this->sendMessage($this->chatId, "Я тебя не понимаю!(");
        }
        catch (Exception $exception) {
            $this->sendMessage($this->chatId, $exception->getMessage());
        }
    }

    /**
     * @throws VKApiMessagesPrivacyException
     * @throws VKApiMessagesDenySendException
     * @throws VKApiMessagesTooLongMessageException
     * @throws VKApiMessagesChatUserNoAccessException
     * @throws VKApiMessagesTooManyPostsException
     * @throws VKApiMessagesChatBotFeatureException
     * @throws VKClientException
     * @throws VKApiMessagesCantFwdException
     * @throws VKApiMessagesUserBlockedException
     * @throws VKApiMessagesKeyboardInvalidException
     * @throws VKApiException
     * @throws VKApiMessagesTooLongForwardsException
     * @throws VKApiMessagesContactNotFoundException
     * @throws Exception
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
     * @throws VKApiMessagesPrivacyException
     * @throws VKApiMessagesDenySendException
     * @throws VKApiMessagesTooLongMessageException
     * @throws VKApiMessagesChatUserNoAccessException
     * @throws VKApiMessagesTooManyPostsException
     * @throws VKApiMessagesChatBotFeatureException
     * @throws VKClientException
     * @throws VKApiMessagesCantFwdException
     * @throws VKApiMessagesUserBlockedException
     * @throws VKApiException
     * @throws VKApiMessagesKeyboardInvalidException
     * @throws VKApiMessagesTooLongForwardsException
     * @throws VKApiMessagesContactNotFoundException
     * @throws Exception
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
     * @throws VKApiMessagesPrivacyException
     * @throws VKApiMessagesDenySendException
     * @throws VKApiMessagesTooLongMessageException
     * @throws VKApiMessagesChatUserNoAccessException
     * @throws VKApiMessagesTooManyPostsException
     * @throws VKApiMessagesChatBotFeatureException
     * @throws VKClientException
     * @throws VKApiMessagesCantFwdException
     * @throws VKApiMessagesUserBlockedException
     * @throws VKApiMessagesKeyboardInvalidException
     * @throws VKApiException
     * @throws VKApiMessagesContactNotFoundException
     * @throws VKApiMessagesTooLongForwardsException
     */
    private function processDocumentComparison()
    {
        try {
            $attachmentData = $this->messageInfo['attachments'];
            if (count($attachmentData) > 1) {
                $this->sendMessageWithTutorialReference("Ошибка! Число вложений не должно превышать единицы. Нажмите \"Справка\", чтобы перечитать правила использования бота.");
                return;
            }
            $checkedAttachment = $attachmentData[0]->doc;
            if (!in_array($checkedAttachment->ext, $this->allowedExtensions)) {
                $this->sendMessageWithTutorialReference("Ошибка! Формат вложения не соответствует требованиям. Нажмите \"Справка\", чтобы перечитать правила использования бота.");
                return;
            }
            $fileName = $this->downloadFile($checkedAttachment->url, $checkedAttachment->title);
            $checker = new FileOriginalityChecker(3);
            $response = $checker->checkOriginality($fileName);
            $similarity = $response['percents'];
            $closestFileName = $response['name'];
            UploadedDocument::create([
                'document_title' => $checkedAttachment->title,
                'document_size' => $checkedAttachment->size,
                'document_path' => $fileName,
                'highest_similarity' => $similarity,
                'uploader_id' => User::select('id')
                    ->where('vk_id', $this->chatId)
                    ->get()
                    ->first()
                    ->id,
                'most_similar_document_id' => is_null($response['name']) ? null : UploadedDocument::select('id')
                    ->where('document_path', $closestFileName)
                    ->get()
                    ->first()
                    ->id
            ]);
            $originality = 100 - $similarity;
            if ($similarity > 0) {
                $this->sendMessage($this->chatId, "Результат проверки:
                    Ваш документ оригинален на $originality%.
                    Наибольшее совпадение с документами, имеющимися в системе: $similarity%.
                    Наибольшее совпадение замечено с документом: $closestFileName");
                return;
            }
            $this->sendMessage($this->chatId, "Результат проверки:
                Ваш документ оригинален на $originality%.
                Наибольшее совпадение с документами, имеющимися в системе: $similarity%.");

        }
        catch (Exception $exception) {
            $this->sendMessage($this->chatId, $exception->getMessage());
            //$this->sendErrorMessageWithTutorialReference("Произошла ошибка обработки вложения. Прочитайте требования к отправляемым вложениям в разделе \"Справка\"");
        }
    }

    /**
     * @throws VKApiMessagesDenySendException
     * @throws VKApiMessagesPrivacyException
     * @throws VKApiMessagesTooLongMessageException
     * @throws VKApiMessagesChatUserNoAccessException
     * @throws VKApiMessagesTooManyPostsException
     * @throws VKApiMessagesChatBotFeatureException
     * @throws VKClientException
     * @throws VKApiMessagesCantFwdException
     * @throws VKApiMessagesUserBlockedException
     * @throws VKApiMessagesKeyboardInvalidException
     * @throws VKApiException
     * @throws VKApiMessagesTooLongForwardsException
     * @throws VKApiMessagesContactNotFoundException
     */
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

    private function downloadFile($url, $namePivot) : string
    {
        $fullName = uniqid() . '_' . str_replace(' ', '_', $namePivot);
        Storage::disk('uploads')->put($fullName, file_get_contents($url), 'public');
        return $fullName;
    }
}
