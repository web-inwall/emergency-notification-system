<?php

namespace App\Interfaces;

interface SendNotificationServiceInterface
{
    public function checkingUsersFields($users);

    public function checkingSendingMethodProcessing();

    public function getUsersForProcessingTemplateData();

    public function setData($data, $message);
}
