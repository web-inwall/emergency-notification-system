<?php

namespace App\Interfaces;

interface GmailRepositoryInterface
{
    public function createLogData($recipient, $status);
}
