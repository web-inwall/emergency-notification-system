<?php

namespace App\Repositories\Communications;

use App\Interfaces\TelegramRepositoryInterface;
use App\Models\Communications\TelegramLog;
use Exception;
use Illuminate\Support\Facades\Http;

class TelegramRepository implements TelegramRepositoryInterface
{
    public function createLogData(string $chatId, string $status): void
    {
        TelegramLog::create([
            'chat_id' => $chatId,
            'status' => $status,
        ]);
    }

    public function sendTelegramMessage(string $chatId, string $messageText): void
    {
        try {
            $response = Http::post('https://api.telegram.org/bot'.env('TELEGRAM_BOT_TOKEN').'/sendMessage', [
                'chat_id' => $chatId,
                'text' => $messageText,
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new Exception('Telegram API Error: '.$response->getBody());
            }

            $this->createLogData($chatId, 'success');
        } catch (Exception $e) {
            throw new Exception('Failed to send Telegram message: '.$e->getMessage());
        }
    }
}
