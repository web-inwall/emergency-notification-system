<?php

namespace App\Http\Controllers;

use App\Mail\Email;
use Illuminate\Support\Facades\Mail;
use App\Interfaces\EmailControllerInterface;
use App\Http\Controllers\SendNotificationController;
use App\Interfaces\SendNotificationControllerInterface;

class EmailController extends Controller implements EmailControllerInterface
{
    protected $messageForSend;

    public function __construct($messageForSend)
    {
        $this->messageForSend = $messageForSend;
    }

    public function sendEmail() {

        $recipient = ['inwall391nas@gmail.com', 'asjagkk2124@gmail.com', 'inwallbz@gmail.com'];

        $data = [
            'name' => 'Здесь имя получателя',
            'message' => $this->messageForSend,
        ];
        
        Mail::to($recipient)
            ->send(new Email($data['name'], $data['message']));
        }
}