<?php

namespace App\Repositories;

use App\Interfaces\NotificationTemplateRepositoryInterface;
use App\Models\Notification;
use App\Models\Recipient;
use Illuminate\Database\Eloquent\Collection;

class NotificationTemplateRepository implements NotificationTemplateRepositoryInterface
{
    public function getDataTemplates(): array
    {
        $templates = $this->getNotificationTemplates();

        $formattedTemplates = $this->formatTemplates($templates);

        return ['templates' => $formattedTemplates];
    }

    private function getNotificationTemplates(): Collection
    {
        return Notification::join('notification__recipients', 'notifications.id', '=', 'notification__recipients.notification_id')
            ->get(['notifications.id', 'notifications.template_name', 'notifications.message', 'notification__recipients.recipient_id']);
    }

    private function formatTemplates(Collection $templates): array
    {
        $formattedTemplates = [];

        foreach ($templates as $template) {
            $userIds = array_map('intval', explode(',', $template->recipient_id));

            $users = $this->getUsersByIds($userIds);

            $formattedTemplates[] = [
                'template_name' => $template->template_name,
                'message' => $template->message,
                'users' => $users->toArray(),
            ];
        }

        return $formattedTemplates;
    }

    private function getUsersByIds(array $userIds): Collection
    {
        return Recipient::whereIn('id', $userIds)->get(['bio', 'link', 'address']);
    }
}
