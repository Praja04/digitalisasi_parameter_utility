<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TelegramService
{
    protected $botToken;
    protected $chatId;

    public function __construct()
    {
        $this->botToken = config('services.telegram.bot_token');
        $this->chatId = config('services.telegram.chat_id');
    }

    public function sendMessage($message)
    {
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        $response = Http::post($url, [
            'chat_id' => $this->chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ]);

        return $response->successful();
    }
}
