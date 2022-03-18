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

    public function sendService($service, $path, $keyboard)
    {
        try {
            if (!is_null($service->discount))
                $discount = $service->discount."%";
            else
                $discount = "отсутствует";
            $caption = "<b>Название:</b> $service->name
<b>Описание:</b> $service->description
<b>Скидка:</b> $discount
<b>Изначальная цена:</b> $service->price
<b>Число заказов:</b> $service->orders_number";
            $this->bot->sendPhoto([
                "chat_id" => $this->chatId,
                "photo" => $path,
                "caption" => $caption,
                "parse_mode" => "HTML",
                'reply_markup' => json_encode([
                    'inline_keyboard' => $keyboard
                ])
            ]);
        }
        catch (\Exception $exception) {
            $this->sendMessage($this->chatId, $exception->getMessage());
        }
        return $this;
    }

    public function sendPhoto($chatId, $caption, $path): BaseBot
    {
        try {
            $this->bot->sendPhoto([
                "chat_id" => $this->chatId,
                "photo" => $path,
                "caption" => $caption,
                "parse_mode" => "HTML"
            ]);
        }
        catch (\Exception $exception) {
            $this->sendMessage($this->chatId, $exception->getMessage());
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
            $this->sendMessage($this->chatId, $exception->getMessage());
        }
        return $this;
    }

    public function replyInvoice($title, $description, $prices, $data)
    {
        return $this->sendInvoice($this->chatId, $title, $description, $prices, $data);
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
            $this->sendMessage($this->chatId, $exception->getMessage());
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
            $this->bot->sendMessage([
                "chat_id" => $chatId,
                "text" => $exception->getMessage(),
                "parse_mode" => "HTML",
            ]);
        }
        return $this;
    }

    public function reply($message)
    {
        return $this->sendMessage($this->chatId, $message);
    }

    public function replyKeyboard($message, $keyboard = [])
    {
        return $this->sendReplyKeyboard($this->chatId, $message, $keyboard);
    }

    public function replyEditInlineKeyboard($messageId, $keyboard)
    {
        return $this->editInlineKeyboard($this->chatId, $messageId, $keyboard);
    }

    public function inlineKeyboard($message, $keyboard = [])
    {
        return $this->sendInlineKeyboard($this->chatId, $message, $keyboard);
    }

    public function replyPhoto($caption, $path)
    {
        try {
            return $this->sendPhoto($this->chatId, $caption, $path);
        }
        catch (\Exception $exception) {
            $this->sendMessage($this->chatId, $exception->getMessage());
            return 0;
        }
    }
}
