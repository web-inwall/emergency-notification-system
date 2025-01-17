<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use App\Models\Notification_Recipient;
use App\Services\NotificationInterface;

class NotificationService implements NotificationInterface
{
    public function sendNotifications($templateName, $message)
    {
        $groupNotification = Notification::create([
            'template_name' => $templateName,
            'message' => $message,
        ]);

        // Получение всех пользователей
        $users = User::all();

        $notificationRecipients = [];
        foreach ($users as $user) {
            $notificationRecipients[] = [
                'notification_id' => $groupNotification->id,
                'user_id' => $user->id,
            ];
        }

        // Создание записей в таблице notification__recipients для всех user_id
        Notification_Recipient::insert($notificationRecipients);
    }
}