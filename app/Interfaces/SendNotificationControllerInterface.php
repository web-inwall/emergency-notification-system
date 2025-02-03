<?php

namespace App\Interfaces;

interface SendNotificationControllerInterface
{
    public function processingFormData($data, $message);

    public function processingTemplateData($templateName, $message);
}
