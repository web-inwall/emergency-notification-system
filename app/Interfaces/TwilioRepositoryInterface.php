<?php

namespace App\Interfaces;

interface TwilioRepositoryInterface
{
    public function createSms(array $result): void;

    public function createLogData(array $logData): void;
}
