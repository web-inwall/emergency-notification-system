<?php

namespace App\Repositories;

use App\Interfaces\NotificationUserRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Notification_Recipient;

class NotificationUserRepository implements NotificationUserRepositoryInterface
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createNotificationUsers(array $csvData, object $notificationObject): void
    {
        $userIds = $this->getUserIdsFromData($csvData);
        $userIdsString = $this->implodeUserIds($userIds);

        $this->saveNotificationRecipient($userIdsString, $notificationObject);
    }

    private function getUserIdsFromData(array $csvData): array
    {
        $batchId = $csvData['batchId'];

        return $this->userRepository->getUserIdsByBatchId($batchId);
    }

    private function implodeUserIds(array $userIds): string
    {
        return implode(',', $userIds);
    }

    private function saveNotificationRecipient(string $userIdsString, object $notificationObject): void
    {
        try {
            Notification_Recipient::create([
                'recipient_id' => $userIdsString,
                'notification_id' => $notificationObject->id,
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Ошибка создания связи уведомления и пользователя: '.$e->getMessage());
        }
    }
}
