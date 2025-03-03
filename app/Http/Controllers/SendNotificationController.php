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

    public function processingFormData($csvData, $message)
    {
        $this->dataHelper($csvData, $message);
    }

    public function processingTemplateData($templateName, $message)
    {
        $this->dataHelper($templateName, $message);
    }

    public function dataHelper($csvData, $message)
    {
        $this->sendNotificationService->setData($csvData, $message);

        $this->sendNotificationService->checkingSendingMethodProcessing();
    }

    public function getProcessingSuccessfulFailedSend()
    {
        return $this->sendNotificationService->processingSuccessfulFailedSend();
    }
}
