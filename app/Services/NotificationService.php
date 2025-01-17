<?php

namespace App\Services;

use App\Models\User;
use App\Models\Notification;
use App\Models\Notification_Recipient;
use App\Services\NotificationInterface;

class NotificationService implements NotificationInterface
{
    public function sendNotifications($templateName, $message, $data)
    {

        $groupNotification = Notification::create([
            'template_name' => $templateName,
            'message' => $message,
        ]);

        // // Получение всех user_id из загруженных данных
        // $userIds = array_column($userData, 'id');

        // // Объединение всех user_id в одну строку
        // $userIdsString = implode(',', $userIds);

        // dd($userIds);

        // // Создание одной записи в таблице notification__recipients для всех user_id
        // Notification_Recipient::create([
        //     'notification_id' => $groupNotification->id,
        //     'user_id' => $userIdsString,
        // ]);
    }
}