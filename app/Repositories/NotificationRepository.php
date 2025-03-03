<?php

namespace App\Repositories;

use App\Interfaces\NotificationRepositoryInterface;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;

class NotificationRepository implements NotificationRepositoryInterface
{
    private $notificationObject;

    public function createNotification($templateName, $message)
    {
        $notificationId = DB::table('notifications')->insertGetId([
            'template_name' => $templateName,
            'message' => $message,
        ]);

        $this->notificationObject = Notification::find($notificationId);

        return $this->notificationObject;
    }
}
