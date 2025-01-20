<?php

namespace App\Repositories;

use App\Interfaces\NotificationTemplateRepositoryInterface;
use App\Models\Notification;
use App\Models\User;

class NotificationTemplateRepository implements NotificationTemplateRepositoryInterface
{
    public function getDataTemplates()
    {
        $templates = Notification::join('notification__users', 'notifications.id', '=', 'notification__users.notification_id')
            ->get(['notifications.id', 'notifications.id', 'notifications.template_name', 'notifications.message', 'notification__users.user_id']);

        $formattedTemplates = [];

        foreach ($templates as $template) {
            $userIds = explode(',', $template->user_id);

            $users = User::whereIn('id', $userIds)->get(['bio', 'link', 'address']);

            $formattedTemplate = [
                'id' => $template->id,
                'template_name' => $template->template_name,
                'message' => $template->message,
                'users' => $users->toArray()
            ];

            $formattedTemplates[] = $formattedTemplate;
        }
        return $formattedTemplates;  //содержит массив массивов информации о шаблоне: имя, адрес и тд.
    }
}
