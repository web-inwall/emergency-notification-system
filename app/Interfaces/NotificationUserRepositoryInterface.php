<?php

namespace App\Interfaces;

interface NotificationUserRepositoryInterface
{
    public function createNotificationUsers($csvData, $notificationObject);
}
