<?php

namespace App\Interfaces;

interface TelegramRepositoryInterface
{
    public function createLogData(string $chatId, string $status): void;
}
