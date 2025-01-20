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
        dump($templateName, $message, $data['data']);
    }

    public function processingTemplateData($templateName, $message)
    {
        $response = $this->notificationTemplateRepository->getDataTemplates();
        $this->templates = $response['templates'];

        $selectedTemplate = collect($this->templates)->firstWhere('template_name', $templateName);

        dump('processingTemplateData');
        dump($templateName);
        dump($message);
        dump($selectedTemplate['users']);
    }
}
