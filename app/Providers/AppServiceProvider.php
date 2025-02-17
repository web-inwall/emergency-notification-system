<?php

namespace App\Providers;

use App\Http\Controllers\MainController;
use App\Http\Controllers\SendNotificationController;
use App\Http\Controllers\TwilioSmsController;
use App\Interfaces\DeleteDataRepositoryInterface;
use App\Interfaces\FileReaderInterface;
use App\Interfaces\GmailRepositoryInterface;
use App\Interfaces\MainControllerInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\NotificationTemplateRepositoryInterface;
use App\Interfaces\NotificationUserRepositoryInterface;
use App\Interfaces\SendNotificationControllerInterface;
use App\Interfaces\SendNotificationServiceInterface;
use App\Interfaces\TelegramRepositoryInterface;
use App\Interfaces\TwilioRepositoryInterface;
use App\Interfaces\TwilioSmsControllerInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\Communications\GmailRepository;
use App\Repositories\Communications\TelegramRepository;
use App\Repositories\Communications\TwilioRepository;
use App\Repositories\DeleteDataRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\NotificationTemplateRepository;
use App\Repositories\NotificationUserRepository;
use App\Repositories\UserRepository;
use App\Services\FileReaderService;
use App\Services\SendNotificationService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(MainControllerInterface::class, MainController::class);
        $this->app->bind(FileReaderInterface::class, FileReaderService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(NotificationUserRepositoryInterface::class, NotificationUserRepository::class);
        $this->app->bind(NotificationTemplateRepositoryInterface::class, NotificationTemplateRepository::class);
        $this->app->bind(SendNotificationControllerInterface::class, SendNotificationController::class);
        $this->app->bind(SendNotificationServiceInterface::class, SendNotificationService::class);
        $this->app->bind(DeleteDataRepositoryInterface::class, DeleteDataRepository::class);
        $this->app->bind(TwilioSmsControllerInterface::class, TwilioSmsController::class);
        $this->app->bind(GmailRepositoryInterface::class, GmailRepository::class);
        $this->app->bind(TwilioRepositoryInterface::class, TwilioRepository::class);
        $this->app->bind(TelegramRepositoryInterface::class, TelegramRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        URL::forceScheme('https');
    }
}
