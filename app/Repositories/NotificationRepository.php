<?php

namespace App\Repositories;

use App\Interfaces\NotificationRepositoryInterface;
use App\Models\Notification;

class NotificationRepository implements NotificationRepositoryInterface
{
    private $groupNotification;

    public function createNotification($templateName, $message)
    {
        $this->groupNotification = Notification::create([
            'template_name' => $templateName,
            'message' => $message,
        ]);
        return $this->groupNotification;
    }
}