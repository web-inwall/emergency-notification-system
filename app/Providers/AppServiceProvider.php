<?php

namespace App\Providers;

use App\Services\CSVFileReader;
use App\Repositories\UserRepository;
use App\Services\FileReaderInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(FileReaderInterface::class, CSVFileReader::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}