<?php

namespace App\Services;

use App\Models\Notification;
use App\Services\NotificationInterface;

class NotificationService implements NotificationInterface
{
    public function sendNotifications($templateName, $message)
    {
        Notification::create([
            'template_name' => $templateName,
            'message' => $message,
        ]);
    }
}