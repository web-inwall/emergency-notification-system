<?php

namespace App\Services;

use Exception;
use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\SendNotificationServiceInterface;
use App\Interfaces\NotificationTemplateRepositoryInterface;

class SendNotificationService implements SendNotificationServiceInterface {
    
    protected $notificationTemplateRepository;
    // protected $templates;
    // protected $data;
    // protected $selectedTemplateUsers;
    // protected $message;

    protected $arrayAllSendingMethod;
    protected $name;
    protected $users;
    protected $recipient;
    protected $data = [];

    protected $message;
    protected $templates;
    protected $templateName;

    protected $arrayUsersSMS = [];
    protected $arrayUsersTelegram = [];
    protected $arrayUsersGmail = [];


    public function __construct(NotificationTemplateRepositoryInterface $notificationTemplateRepository)
    {
        $this->notificationTemplateRepository = $notificationTemplateRepository;
    }

    public function setData($data, $message) 
    {
        $this->message = $message;

        if(!empty($data) && is_array($data) && array_key_exists('data', $data)) {
            $this->users = $data['data'];
        }
        else {
            $this->templateName = $data;

            if (!empty($this->templateName)) {
                $this->getUsersForProcessingTemplateData();
            }
        }
    }

    public function getUsersForProcessingTemplateData() {

        $response = $this->notificationTemplateRepository->getDataTemplates();
        $this->templates = $response['templates'];
        $selectedTemplate = collect($this->templates)->firstWhere('template_name', $this->templateName);

        $this->users = $selectedTemplate['users'];
    }


    public function checkingSendingMethodProcessing() {
        
        $this->checkingUsersFields($this->users);
    
                if(!empty($this->arrayAllSendingMethod)) {
                    
                    if(!empty($this->arrayUsersGmail)) {
                        $this->sendGmail($this->arrayUsersGmail);
                    }
        
                    if(!empty($this->arrayUsersSMS)) {
                        $this->sendSMS($this->arrayUsersSMS);
                    }
        
                    if(!empty($this->arrayUsersTelegram)) {
                        $this->sendTelegram($this->arrayUsersTelegram);
                    }
                }
            // }
        // }

    }


    public function checkingUsersFields($users) {
        
        foreach($this->users as $user) {
            if($user['link'] === 'gmail') {
                $this->arrayUsersGmail[] = $user;
            }
        
            elseif($user['link'] === 'sms') {
                $this->arrayUsersSMS[] = $user;
            }
        
            elseif($user['link'] === 'telegram') {
                $this->arrayUsersTelegram[] = $user;
            }
        }

        $this->arrayAllSendingMethod[] = $this->arrayUsersGmail;
        $this->arrayAllSendingMethod[] = $this->arrayUsersSMS;
        $this->arrayAllSendingMethod[] = $this->arrayUsersTelegram;
        
        return $this->arrayAllSendingMethod;

    }

    
    public function sendGmail($arrayUsersGmail) {

        foreach ($arrayUsersGmail as $user) {
            $this->name [] = $user['bio'];
            $this->recipient [] = $user['address'];
        }

        foreach ($this->recipient as $key => $recipient) {
            $userName = $this->name[$key] ?? ''; // Получаем имя получателя из массива $this->name
            $userMessage = strval($this->message); // Используем одно сообщение для всех получателей
        
            try {
                Mail::to($recipient)
                    ->send(new Email($userName, $userMessage));
                
                // Сообщение об успешной отправке
                echo "Письмо успешно отправлено на адрес: $recipient<br>";
            } catch (Exception $e) {
                // Сообщение об ошибке
                echo "Ошибка при отправке письма на адрес: $recipient. Ошибка: " . $e->getMessage() . "<br>";
            }
        }
    }


    private function sendSMS($arrayUsersSMS) {
        echo 'Отправка на SMS';
    }

    private function sendTelegram($arrayUsersTelegram) {
        echo 'Отправка на Telegram';
    }
}