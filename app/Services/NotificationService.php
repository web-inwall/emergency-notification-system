<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Notification_Recipient;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\NotificationInterface;
use Illuminate\Support\Facades\DB;

use AppRepositoriesUserRepository;

class NotificationService implements NotificationInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function sendNotifications($templateName, $message, $data)
    {
        $batchId = $data['batchId']; // Получение batchId из данных
        $userData = $data['data']; // Получение данных о пользователях

        $groupNotification = Notification::create([
            'template_name' => $templateName,
            'message' => $message,
        ]);

        $userIds = $this->userRepository->getUserIdsByBatchId($batchId); // Получение ID пользователей по batch_id

        $userIdsString = implode(',', $userIds); // Объединение ID пользователей

        $notificationRecipient = new Notification_Recipient();
        $notificationRecipient->user_id = $userIdsString;
        $notificationRecipient->notification_id = $groupNotification->id;
        $notificationRecipient->created_at = now();
        $notificationRecipient->updated_at = now();
        $notificationRecipient->save();
    }
}