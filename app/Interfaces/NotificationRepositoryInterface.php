<?php

namespace App\Interfaces;

use App\Models\Notification;

interface NotificationRepositoryInterface
{
    public function createNotification(string $templateName, string $message): Notification;
}
