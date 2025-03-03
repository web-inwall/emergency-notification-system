<?php

namespace App\Repositories;

use App\Interfaces\NotificationUserRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class NotificationUserRepository implements NotificationUserRepositoryInterface
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function createNotificationUsers($csvData, $notificationObject)
    {
        $userIds = $this->getUserIdsFromData($csvData);
        $userIdsString = $this->implodeUserIds($userIds);

        $this->saveNotificationRecipient($userIdsString, $notificationObject);
    }

    private function getUserIdsFromData($csvData)
    {
        $batchId = $csvData['batchId'];

        return $this->userRepository->getUserIdsByBatchId($batchId);
    }

    private function implodeUserIds($userIds)
    {
        return implode(',', $userIds);
    }

    private function saveNotificationRecipient($userIdsString, $notificationObject)
    {
        DB::table('notification__recipients')->insert([
            'recipient_id' => $userIdsString,
            'notification_id' => $notificationObject->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
