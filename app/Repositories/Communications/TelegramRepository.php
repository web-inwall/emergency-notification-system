<?php

namespace App\Repositories\Communications;

use App\Interfaces\TelegramRepositoryInterface;
use App\Models\Communications\TelegramLog;

class TelegramRepository implements TelegramRepositoryInterface
{
    public function createLogData($chatId, $status)
    {
        TelegramLog::create([
            'chat_id' => $chatId,
            'status' => $status,
        ]);
    }
}
