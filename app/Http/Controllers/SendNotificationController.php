<?php

namespace App\Http\Controllers;

use App\Interfaces\SendNotificationControllerInterface;
use App\Interfaces\SendNotificationServiceInterface;

class SendNotificationController extends Controller implements SendNotificationControllerInterface
{
    protected $sendNotificationService;

    public function __construct(SendNotificationServiceInterface $sendNotificationService)
    {
        $this->sendNotificationService = $sendNotificationService;
    }

    public function processingFormData($data, $message)
    {
        $this->dataHelper($data, $message);
    }

    public function processingTemplateData($templateName, $message)
    {
        $this->dataHelper($templateName, $message);
    }

    public function dataHelper($data, $message)
    {
        $this->sendNotificationService->setData($data, $message);

        $this->sendNotificationService->checkingSendingMethodProcessing();
    }

    public function getProcessingSuccessfulFailedSend()
    {
        return $this->sendNotificationService->processingSuccessfulFailedSend();
    }
}
