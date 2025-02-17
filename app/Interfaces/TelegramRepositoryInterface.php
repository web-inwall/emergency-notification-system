<?php

namespace App\Interfaces;

interface TelegramRepositoryInterface
{
    public function createLogData($chatId, $status);
}
