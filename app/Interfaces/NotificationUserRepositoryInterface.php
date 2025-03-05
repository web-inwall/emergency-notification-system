<?php

namespace App\Interfaces;

interface NotificationUserRepositoryInterface
{
    public function createNotificationUsers(array $csvData, object $notificationObject): void;
}
