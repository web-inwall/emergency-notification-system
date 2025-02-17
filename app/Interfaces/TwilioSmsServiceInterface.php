<?php

namespace App\Interfaces;

interface TwilioSmsServiceInterface
{
    public function sendMessage($to, $body): array;
}
