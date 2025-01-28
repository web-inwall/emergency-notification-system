<?php

namespace App\Providers;

use App\Services\FileReaderService;

use App\Repositories\UserRepository;
use App\Interfaces\FileReaderInterface;

use Illuminate\Support\ServiceProvider;
use App\Http\Controllers\MainController;

use App\Services\SendNotificationService;
use App\Repositories\DeleteDataRepository;

use App\Interfaces\MainControllerInterface;
use App\Interfaces\UserRepositoryInterface;

use App\Repositories\NotificationRepository;
use App\Repositories\NotificationUserRepository;

use App\Interfaces\DeleteDataRepositoryInterface;
use App\Interfaces\NotificationRepositoryInterface;
use App\Http\Controllers\SendNotificationController;
use App\Interfaces\SendNotificationServiceInterface;
use App\Repositories\NotificationTemplateRepository;
use App\Interfaces\NotificationUserRepositoryInterface;
use App\Interfaces\SendNotificationControllerInterface;
use App\Interfaces\NotificationTemplateRepositoryInterface;

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
