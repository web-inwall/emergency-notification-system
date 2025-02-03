<?php

namespace App\Repositories;

use App\Interfaces\NotificationTemplateRepositoryInterface;
use App\Models\Notification;
use App\Models\User;
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
        return Notification::join('notification__users', 'notifications.id', '=', 'notification__users.notification_id')
            ->get(['notifications.id', 'notifications.template_name', 'notifications.message', 'notification__users.user_id']);
    }

    private function formatTemplates(Collection $templates): array
    {
        $formattedTemplates = [];

        foreach ($templates as $template) {
            $userIds = explode(',', $template->user_id);

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
        return User::whereIn('id', $userIds)->get(['bio', 'link', 'address']);
    }
}
