<?php

namespace App\Interfaces;

interface SendNotificationControllerInterface
{
    public function processingFormData($data, $templateName, $message);
    public function processingTemplateData($templateName, $message);
}
