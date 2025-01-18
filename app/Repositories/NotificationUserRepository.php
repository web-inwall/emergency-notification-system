<?php

namespace App\Repositories;

use App\Interfaces\NotificationUserRepositoryInterface;
use App\Models\Notification_User;
use App\Repositories\UserRepository;

class NotificationUserRepository implements NotificationUserRepositoryInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createNotificationUsers($data, $groupNotification)
    {
        $batchId = $data['batchId']; // Получение batchId из данных

        $userIds = $this->userRepository->getUserIdsByBatchId($batchId); // Получение ID пользователей по batch_id

        $userIdsString = implode(',', $userIds); // Объединение ID пользователей

        $notificationRecipient = new Notification_User();
        $notificationRecipient->user_id = $userIdsString;
        $notificationRecipient->notification_id = $groupNotification->id;
        $notificationRecipient->created_at = now();
        $notificationRecipient->updated_at = now();
        $notificationRecipient->save();
    }
}