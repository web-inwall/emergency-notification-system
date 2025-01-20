<?php

namespace App\Http\Controllers;

use App\Interfaces\SendNotificationControllerInterface;
use App\Interfaces\NotificationTemplateRepositoryInterface;

class SendNotificationController extends Controller implements SendNotificationControllerInterface
{
    protected $notificationTemplateRepository;
    public $templates;

    public function __construct(NotificationTemplateRepositoryInterface $notificationTemplateRepository)
    {
        $this->notificationTemplateRepository = $notificationTemplateRepository;
    }

    public function processingFormData($data, $templateName, $message)
    {
        dump($data['data'], $templateName, $message);
    }

    public function processingTemplateData($templateName)
    {
        $response = $this->notificationTemplateRepository->getDataTemplates();
        $this->templates = $response['templates'];
        $selectedTemplate = collect($this->templates)->firstWhere('template_name', $templateName);

        dd($selectedTemplate);
    }
}
