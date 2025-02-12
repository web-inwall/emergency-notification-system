<?php

namespace App\Interfaces;

interface NotificationRepositoryInterface
{
    public function createNotification($templateName, $message);
}
