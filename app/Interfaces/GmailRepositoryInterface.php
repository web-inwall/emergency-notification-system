<?php

namespace App\Interfaces;

interface GmailRepositoryInterface
{
    public function createLogData(string $recipient, string $status): void;
}
