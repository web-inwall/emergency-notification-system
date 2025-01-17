<?php

namespace App\Providers;

use App\Services\FileReaderService;
use App\Repositories\UserRepository;
use App\Services\FileReaderInterface;
use App\Services\NotificationService;
use App\Services\NotificationInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(FileReaderInterface::class, FileReaderService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(NotificationInterface::class, NotificationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot() {}
}