<?php

namespace App\Http\Controllers;

use App\Interfaces\SendNotificationControllerInterface;
use App\Interfaces\SendNotificationServiceInterface;

class SendNotificationController extends Controller implements SendNotificationControllerInterface
{
    protected SendNotificationServiceInterface $sendNotificationService;

    public function __construct(SendNotificationServiceInterface $sendNotificationService)
    {
        $this->sendNotificationService = $sendNotificationService;
    }

    public function processingFormData(array $csvData, string $message): void
    {
        $this->dataHelper($csvData, $message);
    }

    public function processingTemplateData(string $templateName, string $message): void
    {
        $this->dataHelper($templateName, $message);
    }

    private function dataHelper(mixed $csvData, string $message): void
    {
        $this->sendNotificationService->setData($csvData, $message);

        $this->sendNotificationService->checkingSendingMethodProcessing();
    }

    public function getProcessingSuccessfulFailedSend(): array
    {
        return $this->sendNotificationService->processingSuccessfulFailedSend();
    }
}
