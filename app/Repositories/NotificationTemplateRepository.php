<?php

namespace App\Repositories;

use App\Interfaces\NotificationTemplateRepositoryInterface;
use App\Models\Notification;

class NotificationTemplateRepository implements NotificationTemplateRepositoryInterface
{
    public function getAllTemplates()
    {
        $templatesExist = Notification::count() > 0;
        return $templates = $templatesExist ? Notification::all(['template_name', 'message']) : [];
    }
}
