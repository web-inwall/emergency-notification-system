<?php

namespace App\Providers;

use App\Http\Controllers\MainController;
use App\Http\Controllers\SendNotificationController;
use App\Interfaces\DeleteDataRepositoryInterface;
use App\Interfaces\FileReaderInterface;
use App\Interfaces\MainControllerInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Interfaces\NotificationTemplateRepositoryInterface;
use App\Interfaces\NotificationUserRepositoryInterface;
use App\Interfaces\SendNotificationControllerInterface;
use App\Interfaces\SendNotificationServiceInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\DeleteDataRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\NotificationTemplateRepository;
use App\Repositories\NotificationUserRepository;
use App\Repositories\UserRepository;
use App\Services\FileReaderService;
use App\Services\SendNotificationService;
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

    }

    /**
     * Bootstrap any application services.
     */
    public function boot() {}
}
