<?php

namespace App\Services;

use App\Interfaces\GmailRepositoryInterface;
use App\Interfaces\NotificationTemplateRepositoryInterface;
use App\Interfaces\SendNotificationServiceInterface;
use App\Interfaces\TwilioSmsControllerInterface;
use App\Mail\Email;
use App\Notifications\TelegramNotification;
use App\Services\Communications\TwilioSmsService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendNotificationService implements SendNotificationServiceInterface
{
    protected $notificationTemplateRepository;

    protected $gmailRepository;

    protected $arrayAllSendingMethod;

    protected $name;

    protected $userName;

    protected $users;

    protected $recipient;

    protected $data = [];

    protected $message;

    protected $templates;

    protected $templateName;

    protected $twilioSmsController;

    protected $twilioSmsService;

    protected $arrayUsersSms = [];

    protected $arrayUsersTelegram = [];

    protected $arrayUsersGmail = [];

    public function __construct(
        NotificationTemplateRepositoryInterface $notificationTemplateRepository,
        TwilioSmsControllerInterface $twilioSmsController,
        GmailRepositoryInterface $gmailRepository,
        TwilioSmsService $twilioSmsService,
    ) {
        $this->notificationTemplateRepository = $notificationTemplateRepository;
        $this->twilioSmsController = $twilioSmsController;
        $this->gmailRepository = $gmailRepository;
        $this->twilioSmsService = $twilioSmsService;
    }

    public function setData($data, $message)
    {
        $this->message = $message;

        if (! empty($data) && is_array($data) && array_key_exists('data', $data)) {
            $this->users = $data['data'];
        } else {
            $this->templateName = $data;

            if (! empty($this->templateName)) {
                $this->getUsersForProcessingTemplateData();
            }
        }
    }

    public function getUsersForProcessingTemplateData()
    {

        $response = $this->notificationTemplateRepository->getDataTemplates();
        $this->templates = $response['templates'];
        $selectedTemplate = collect($this->templates)->firstWhere('template_name', $this->templateName);

        $this->users = $selectedTemplate['users'];
    }

    public function checkingSendingMethodProcessing()
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

    public function checkingUsersFields($users)
    {

        foreach ($this->users as $user) {
            if ($user['link'] === 'gmail') {
                $this->arrayUsersGmail[] = $user;
            } elseif ($user['link'] === 'sms') {
                $this->arrayUsersSms[] = $user;
            } elseif ($user['link'] === 'telegram') {
                $this->arrayUsersTelegram[] = $user;
            }
        }

        $this->arrayAllSendingMethod[] = $this->arrayUsersGmail;
        $this->arrayAllSendingMethod[] = $this->arrayUsersSms;
        $this->arrayAllSendingMethod[] = $this->arrayUsersTelegram;

        return $this->arrayAllSendingMethod;

    }

    public function sendGmail($arrayUsersGmail)
    {

        $nameMethod = 'Gmail';

        foreach ($arrayUsersGmail as $user) {
            $this->name[] = $user['bio'];
            $this->recipient[] = $user['address'];
        }

        foreach ($this->recipient as $key => $recipient) {
            $userName = $this->name[$key] ?? ''; // Получаем имя получателя из массива $this->name
            $userMessage = $this->message; // Используем одно сообщение для всех получателей

            try {
                Mail::to($recipient)
                    ->send(new Email($userName, $userMessage));

                $this->gmailRepository->createLogData($recipient, 'success');

                $this->succcessMessage($nameMethod);

            } catch (Exception $e) {
                Log::error("Ошибка при отправке письма на адрес: $recipient. Ошибка: ".$e->getMessage());

                $this->errorMessage($e, $nameMethod);
            }
        }
    }

    private function sendSms($arrayUsersSms)
    {

        $nameMethod = 'Sms';

        $results = []; // Массив для хранения результатов отправки сообщений

        foreach ($arrayUsersSms as $user) {
            $recipient = $user['address'];
            $userMessage = $user['bio'].': '.$this->message;

            // try {
            //     $sendResult = $this->twilioSmsService->sendMessage($recipient, $userMessage);
            //     if (! isset($sendResult['success']) || ! $sendResult['success']) {
            //         throw new Exception(($sendResult['message'] ?? ''));
            //     }
            //     $results[] = $sendResult; // Сохраняем результат отправки сообщения

            //     $this->succcessMessage($nameMethod);

            // } catch (Exception $e) {
            //     $results[] = 'Send SMS Failed - '.$e->getMessage();

            //     $this->errorMessage($e, $nameMethod);

            // }
        }

        return $results; // Возвращаем результаты отправки сообщений для всех адресатов
    }

    public function sendTelegram()
    {

        $nameMethod = 'Telegram';

        try {
            $telegramNotification = app(TelegramNotification::class, ['message' => $this->message]);
            Notification::route('telegram', [])->notify($telegramNotification);

            $this->succcessMessage($nameMethod);
        } catch (Exception $e) {

            $this->errorMessage($e, $nameMethod);

        }
    }

    private function succcessMessage($nameMethod)
    {

        echo "Письмо успешно отправлено на $nameMethod <br>";

    }

    private function errorMessage($e, $nameMethod)
    {
        $errorMessage = "Ошибка при отправке сообщения в $nameMethod. Ошибка: ".$e->getMessage();
        Log::error($errorMessage);
        echo $errorMessage;
    }
}
