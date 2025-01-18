<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\FileReaderService;
use App\Interfaces\FileReaderInterface;

use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;

use App\Http\Controllers\MainController;
use App\Interfaces\MainControllerInterface;

use App\Repositories\NotificationRepository;
use App\Interfaces\NotificationRepositoryInterface;

use App\Repositories\NotificationUserRepository;
use App\Interfaces\NotificationUserRepositoryInterface;

use App\Repositories\NotificationTemplateRepository;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() {}
}
