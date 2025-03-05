<?php

namespace App\Repositories;

use App\Interfaces\NotificationRepositoryInterface;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function createNotification(string $templateName, string $message): Notification
    {
        $notificationId = DB::table('notifications')->insertGetId([
            'template_name' => $templateName,
            'message' => $message,
        ]);

        return Notification::find($notificationId);
    }
}
