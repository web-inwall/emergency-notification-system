<?php

namespace App\Services;

class NotificationService
{
    public function sendNotifications(array $usersData)
    {
        foreach ($usersData as $user) {
            // Логика отправки уведомлений пользователям
            // Например, можно использовать Mail или другие методы
        }
    }
}