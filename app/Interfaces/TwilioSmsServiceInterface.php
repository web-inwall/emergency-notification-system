<?php

namespace App\Interfaces;

interface TwilioSmsServiceInterface
{
    public function sendMessage(string $to, string $body): array;
}
