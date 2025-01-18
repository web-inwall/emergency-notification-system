<?php

namespace App\Http\Controllers;

use App\Interfaces\NotificationTemplateInterface;
use App\Models\Notification;

class NotificationTemplateController extends Controller implements NotificationTemplateInterface
{
    public function showAllTemplates()
    {
        $templatesExist = Notification::count() > 0;

        if ($templatesExist) {
            $templates = Notification::pluck('template_name')->toArray();
            return response()->json($templates);
        } else {
            return response()->json(['Сохраненных шаблонов нет.']);
        }
    }
}
