<?php

namespace App\Services;

interface NotificationInterface
{
    public function sendNotifications($templateName, $message);
}