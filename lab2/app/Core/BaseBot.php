<?php

namespace App\Core;

abstract class BaseBot extends BotCore
{
    protected $bot;
    protected $chatId;

    public function sendMessage($chatId, $message): BaseBot
    {
        try {
            $this->bot->sendMessage([
               "chat_id" => $chatId,
               "text" => $message,
               "parse_mode" => "HTML"
            ]);
        }
        catch (\Exception $exception) {

        }
        return $this;
    }

    public function sendPhoto($chatId, $caption, $path): BaseBot
    {
        try {
            $this->bot->sendPhoto([
                "chat_id" => $chatId,
                "photo" => $path,
                "caption" => $caption,
                "parse_mode" => "HTML"
            ]);
        }
        catch (\Exception $exception) {

        }
        return $this;
    }

    public function sendReplyKeyboard($chatId, $message, $keyboard): BaseBot
    {
        try {
            $this->bot->sendMessage([
                "chat_id" => $chatId,
                "text" => $message,
                "parse_mode" => "HTML",
                'reply_markup' => json_encode([
                    'keyboard' => $keyboard,
                    'resize_keyboard' => true,
                    'input_field_placeholder' => "Выберите действие:"
                ])
            ]);
        }
        catch (\Exception $exception) {

        }
        return $this;
    }

    public function sendInvoice($chatId, $title, $description, $prices, $data) : BaseBot
    {
        try {
            $this->bot->sendInvoice([
                "chat_id" => $chatId,
                "title" => $title,
                "description" => $description,
                "payload" => $data,
                "provider_token" => env("PAYMENT_PROVIDER_TOKEN"),
                "currency" => env("PAYMENT_PROVIDER_CURRENCY"),
                "prices" => $prices
            ]);
        }
        catch (\Exception $exception) {

        }
        return $this;
    }

    public function editInlineKeyboard($chatId, $messageId, $keyboard): BaseBot
    {
        try {
            $this->bot->editMessageReplyMarkup([
                "chat_id" => $chatId,
                "message_id" => $messageId,
                "parse_mode" => "HTML",
                'reply_markup' => json_encode([
                    'inline_keyboard' => $keyboard
                ])
            ]);
        }
        catch (\Exception $exception) {

        }
        return $this;
    }

    public function sendInlineKeyboard($chatId, $message, $keyboard): BaseBot
    {
        try {
            $this->bot->sendMessage([
                "chat_id" => $chatId,
                "text" => $message,
                "parse_mode" => "HTML",
                'reply_markup' => json_encode([
                    'inline_keyboard' => $keyboard
                ])
            ]);
        }
        catch (\Exception $exception) {

        }
        return $this;
    }

}
