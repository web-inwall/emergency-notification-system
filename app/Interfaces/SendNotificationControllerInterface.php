<?php

namespace App\Interfaces;

interface SendNotificationControllerInterface
{
    public function processingFormData(array $csvData, string $message): void;

    public function processingTemplateData(string $templateName, string $message): void;

    public function getProcessingSuccessfulFailedSend(): array;
}
