<?php

namespace App\Http\Controllers;

use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\EmailInterfaceController;
use App\Interfaces\SendNotificationControllerInterface;
use App\Interfaces\NotificationTemplateRepositoryInterface;

class SendNotificationController extends Controller implements SendNotificationControllerInterface
{
    protected $notificationTemplateRepository;
    public $templates;
    protected $data;
    protected $selectedTemplateUsers;
    protected $message;
    protected $arrayUsersGmail;
    protected $name;
    protected $recipient;

    // protected $emailInterfaceController;

    public function __construct(NotificationTemplateRepositoryInterface $notificationTemplateRepository)
    {
        $this->notificationTemplateRepository = $notificationTemplateRepository;
    }

    public function processingFormData($data, $templateName, $message)
    {
        dump($templateName, $message, $data['data']);
    }


    public function processingTemplateData($templateName, $message)
    {
        $response = $this->notificationTemplateRepository->getDataTemplates();
        $this->templates = $response['templates'];

        $selectedTemplate = collect($this->templates)->firstWhere('template_name', $templateName);


        $this->selectedTemplateUsers = $selectedTemplate['users'];

        $this->arrayUsersGmail = $this->CheckingSendingMethod($this->selectedTemplateUsers);

        $this->message = $message;

        $this->data = [
            'users' => $this->arrayUsersGmail,
            'message' => $this->message,
        ];

        $this->sendGmail();    
    }

    public function CheckingSendingMethod($users) {

        $arrayUsersGmail = []; 

        foreach($users as $user) {
            if($user['link'] === 'gmail') {
                $arrayUsersGmail[] = $user;
            }
        }

        return $arrayUsersGmail;
    }

    
    public function sendGmail() {
        // echo "<pre>";
        // print_r($this->data);
        // echo "</pre>";

        
        foreach ($this->data['users'] as $user) {
            $this->name [] = $user['bio'];
            $this->recipient [] = $user['address'];
        }
        

        echo "<pre>";
        print_r($this->recipient);
        print_r($this->name);
        print_r($this->message);
        echo "</pre>";


        foreach ($this->recipient as $key => $recipient) {
            $name = $this->name[$key] ?? ''; // Получаем имя получателя из массива $this->name
            $message = $this->message; // Используем одно сообщение для всех получателей
        
            // Обработка только строковых значений перед передачей в htmlspecialchars()
            $name = is_string($name) ? htmlspecialchars($name) : '';
            $message = is_string($message) ? htmlspecialchars($message) : '';
        
            Mail::to($recipient)
                ->send(new Email($name, $message));
        }

    }
}



