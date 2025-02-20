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
        $middleware->web(append: [
            StartSession::class, // Добавляем промежуточное программное обеспечение StartSession к веб-промежуточному программному обеспечению
        ])
            ->validateCsrfTokens(except: [
                'livewire/*',
            ])
            ->alias([
                'is-twilio-request' => TwilioRequestIsValid::class,
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
