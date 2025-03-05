<?php

namespace App\Services;

use App\Interfaces\GmailRepositoryInterface;
use App\Interfaces\NotificationTemplateRepositoryInterface;
use App\Interfaces\SendNotificationServiceInterface;
use App\Interfaces\TelegramRepositoryInterface;
use App\Mail\Email;
use App\Services\Communications\TwilioSmsService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotificationService implements SendNotificationServiceInterface
{
    protected NotificationTemplateRepositoryInterface $notificationTemplateRepository;

    protected GmailRepositoryInterface $gmailRepository;

    protected TwilioSmsService $twilioSmsService;

    protected TelegramRepositoryInterface $telegramRepository;

    protected array $arrayAllSendingMethod;

    protected array $name = [];

    protected string $userName;

    protected array $getAllDataUsers;

    protected array $users;

    protected array $recipient;

    protected array $csvData;

    protected string $message;

    protected array $templates;

    protected string $templateName;

    protected array $successRecipientsSms = [];

    protected array $successRecipientsGmail = [];

    protected array $successRecipientsTelegram = [];

    protected array $arrayUsersSms;

    protected array $arrayUsersTelegram;

    protected array $arrayUsersGmail;

    public function __construct(
        NotificationTemplateRepositoryInterface $notificationTemplateRepository,
        GmailRepositoryInterface $gmailRepository,
        TwilioSmsService $twilioSmsService,
        TelegramRepositoryInterface $telegramRepository,
    ) {
        $this->notificationTemplateRepository = $notificationTemplateRepository;
        $this->gmailRepository = $gmailRepository;
        $this->twilioSmsService = $twilioSmsService;
        $this->telegramRepository = $telegramRepository;
    }

    public function setData(mixed $csvData, string $message): void
    {

        $this->message = $message;

        if (! empty($csvData) && is_array($csvData) && array_key_exists('data', $csvData)) {
            $this->users = $csvData['data'];
        } else {
            $this->templateName = $csvData;

            if (! empty($this->templateName)) {
                $this->getUsersForProcessingTemplateData();
            }
        }
    }

    public function getUsersForProcessingTemplateData(): void
    {
        $response = $this->notificationTemplateRepository->getDataTemplates();
        $this->templates = $response['templates'];
        $selectedTemplate = collect($this->templates)->firstWhere('template_name', $this->templateName);

        $this->users = $selectedTemplate['users'];
    }

    public function checkingSendingMethodProcessing(): void
    {
        $this->checkingUsersFields($this->users);

        if (! empty($this->arrayAllSendingMethod)) {
            if (! empty($this->arrayUsersGmail)) {
                $this->sendGmail($this->arrayUsersGmail);
            }

            if (! empty($this->arrayUsersSms)) {
                $this->sendSms($this->arrayUsersSms);
            }

            if (! empty($this->arrayUsersTelegram)) {
                $this->sendTelegram($this->arrayUsersTelegram);
            }
        }
    }

    public function checkingUsersFields(array $users): array
    {
        foreach ($users as $user) {
            if (strtolower($user['link']) == 'gmail') {
                $this->arrayUsersGmail[] = $user;
            } elseif (strtolower($user['link']) == 'sms') {
                $this->arrayUsersSms[] = $user;
            } elseif (strtolower($user['link']) == 'telegram') {
                $this->arrayUsersTelegram[] = $user;
            }
        }

        $this->arrayAllSendingMethod = [$this->arrayUsersGmail, $this->arrayUsersSms, $this->arrayUsersTelegram];

        return $this->arrayAllSendingMethod;
    }

    public function sendGmail(array $arrayUsersGmail): void
    {
        $nameMethod = 'Gmail';

        foreach ($arrayUsersGmail as $user) {
            $this->name[] = $user['bio'];
            $this->recipient[] = $user['address'];
        }

        foreach ($this->recipient as $key => $recipient) {
            $userName = $this->name[$key] ?? '';
            $userMessage = $this->message;

            try {
                Mail::to($recipient)
                    ->send(new Email($userName, $userMessage));

                $this->gmailRepository->createLogData($recipient, 'success');

                $this->successRecipientsGmail[] = $recipient;
            } catch (Exception $e) {
                Log::error("Ошибка при отправке письма на адрес: $recipient. Ошибка: ".$e->getMessage());

                $this->errorMessage($e, $nameMethod);
            }
        }
    }

    private function sendSms(array $arrayUsersSms): array
    {
        $nameMethod = 'Sms';

        $results = [];

        foreach ($arrayUsersSms as $user) {
            $recipient = $user['address'];
            $userMessage = $user['bio'].': '.$this->message;

            try {
                $sendResult = $this->twilioSmsService->sendMessage($recipient, $userMessage);
                if (! isset($sendResult['success']) || ! $sendResult['success']) {
                    throw new Exception(($sendResult['message'] ?? ''));
                }
                $results[] = $sendResult;

                $this->successRecipientsSms[] = $recipient;
            } catch (Exception $e) {
                $results[] = 'Send SMS Failed - '.$e->getMessage();

                $this->errorMessage($e, $nameMethod);
            }
        }

        return $results;
    }

    public function sendTelegram(array $arrayUsersTelegram): void
    {
        $nameMethod = 'Telegram';
        $success = true;
        try {
            $chatId = env('TELEGRAM_CHAT_ID');
            $messageText = $this->message;

            if (empty($chatId)) {
                throw new Exception('TELEGRAM_CHAT_ID environment variable is not set');
            }

            $this->telegramRepository->sendTelegramMessage($chatId, $messageText);
        } catch (Exception $e) {
            $this->errorMessage($e, $nameMethod);
            $success = false;
        }

        if ($success) {
            foreach ($arrayUsersTelegram as $user) {
                $this->successRecipientsTelegram[] = $user['address'];
            }
        }
    }

    private function errorMessage(Exception $e, string $nameMethod): void
    {
        $errorMessage = "Ошибка при отправке сообщения в $nameMethod. Ошибка: ".$e->getMessage();
        Log::error($errorMessage);
        echo $errorMessage;
    }

    public function processingSuccessfulFailedSend(): array
    {
        $resultProcessing = [];
        $resultProcessingSuccessfulSend = array_merge($this->successRecipientsGmail, $this->successRecipientsSms, $this->successRecipientsTelegram);

        foreach ($this->users as $user) {
            $found = false;
            foreach ($resultProcessingSuccessfulSend as $resultProcessingElem) {
                if ($user['address'] === $resultProcessingElem) {
                    $found = true;
                    break;
                }
            }

            if ($found) {
                $resultProcessing['success'][] = $user;
            } else {
                $resultProcessing['fail'][] = $user;
            }
        }

        return $resultProcessing;
    }
}
