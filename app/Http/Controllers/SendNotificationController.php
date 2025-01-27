<?php

namespace App\Http\Controllers;

use Exception;
use App\Interfaces\SendNotificationServiceInterface;
use App\Interfaces\SendNotificationControllerInterface;

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

}



