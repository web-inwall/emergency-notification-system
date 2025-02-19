<?php

use App\Http\Middleware\TwilioRequestIsValid;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            require base_path('routes/web.php');
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(StartSession::class);

        $middleware->validateCsrfTokens(except: [
            'livewire/*',
        ]);
        $middleware->alias([
            'is-twilio-request' => TwilioRequestIsValid::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
