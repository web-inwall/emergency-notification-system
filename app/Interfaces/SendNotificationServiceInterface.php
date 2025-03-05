<?php

namespace App\Interfaces;

interface SendNotificationServiceInterface
{
    public function checkingUsersFields(array $users): array;

    public function checkingSendingMethodProcessing(): void;

    public function getUsersForProcessingTemplateData(): void;

    public function setData(array $csvData, string $message): void;

    public function processingSuccessfulFailedSend(): array;
}
