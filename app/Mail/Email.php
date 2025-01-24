<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Email extends Mailable
{
    use Queueable, SerializesModels;
    private $userName;
    private $userMessage;

    public function __construct($userName, $userMessage)
    {
        $this->userName = $userName;
        $this->userMessage = $userMessage;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Оповещение о чрезвычайной ситуации!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.message',
            with: [
                'userName' => $this->userName,
                'userMessage' => $this->userMessage,
            ],
        );
    }
}
