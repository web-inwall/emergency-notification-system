<?php

namespace App\Providers;

use App\Services\Communications\TwilioService;
use Illuminate\Support\ServiceProvider;

class CustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind('TwilioService', TwilioService::class);
    }
}
