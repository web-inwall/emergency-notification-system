<?php

namespace App\Repositories;

use App\Interfaces\NotificationUserRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Notification_Recipient;

class NotificationUserRepository implements NotificationUserRepositoryInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createNotificationUsers($data, $groupNotification)
    {
        $userIds = $this->getUserIdsFromData($data);
        $userIdsString = $this->implodeUserIds($userIds);
        $this->saveNotificationRecipient($userIdsString, $groupNotification);
    }

    private function getUserIdsFromData($data)
    {
        $batchId = $data['batchId'];

        return $this->userRepository->getUserIdsByBatchId($batchId);
    }

    private function implodeUserIds($userIds)
    {
        return implode(',', $userIds);
    }

    private function saveNotificationRecipient($userIdsString, $groupNotification)
    {
        $notificationRecipient = new Notification_Recipient;
        $notificationRecipient->recipient_id = $userIdsString;
        $notificationRecipient->notification_id = $groupNotification->id;
        $notificationRecipient->created_at = now();
        $notificationRecipient->updated_at = now();
        $notificationRecipient->save();
    }
}
