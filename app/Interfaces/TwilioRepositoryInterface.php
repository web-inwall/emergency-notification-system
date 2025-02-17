<?php

namespace App\Interfaces;

interface TwilioRepositoryInterface
{
    public function createSms($result);

    public function createLogData($logData);
}
