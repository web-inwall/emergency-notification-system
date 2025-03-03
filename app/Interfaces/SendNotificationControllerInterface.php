<?php

namespace App\Interfaces;

interface SendNotificationControllerInterface
{
    public function processingFormData($csvData, $message);

    public function processingTemplateData($templateName, $message);

    public function getProcessingSuccessfulFailedSend();
}
