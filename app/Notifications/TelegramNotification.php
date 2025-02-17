<?php

namespace App\Notifications;

use App\Interfaces\TelegramRepositoryInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TelegramNotification extends Notification
{
    use Queueable;

    private $message;

    private $telegramRepository;

    public function __construct($message, TelegramRepositoryInterface $telegramRepository)
    {
        $this->message = $message;
        $this->telegramRepository = $telegramRepository;
    }

    public function via(object $notifiable): array
    {
        return [TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {

        $chatId = env('TELEGRAM_CHAT_ID');

        try {

            $message = TelegramMessage::create()
                ->to($chatId)
                ->content($this->message);

            $this->telegramRepository->createLogData($chatId, 'success');

            return $message;

        } catch (Exception $e) {
            Log::error('Error in sending Telegram notification: '.$e->getMessage());
        }

    }
}
