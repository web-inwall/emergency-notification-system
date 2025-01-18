<?php

namespace App\Http\Controllers;

use App\Interfaces\NotificationTemplateInterface;
use App\Repositories\NotificationTemplateRepository;

class NotificationTemplateController extends Controller implements NotificationTemplateInterface
{
    protected $notificationTemplateRepository;

    public function __construct(NotificationTemplateRepository $notificationTemplateRepository)
    {
        $this->notificationTemplateRepository = $notificationTemplateRepository;
    }

    public function showAllTemplates()
    {
        $templates = $this->notificationTemplateRepository->getAllTemplates();

        return view('livewire.show-all-templates', compact('templates'));
    }
}
