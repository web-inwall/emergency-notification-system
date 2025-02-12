<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TwilioSmsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::delete('/delete', [HomeController::class, 'delete'])->name('home.delete');

Route::post('/send-form', [MainController::class, 'manageUserNotificationWorkflow'])->name('main.manageUserNotificationWorkflow');

Route::any('/twilio/webhook/status-changed', [TwilioSMSController::class, 'statusChanged'])->middleware(['is-twilio-request'])->name('api.twilio.status-changed');

Route::any('/twilio/webhook/message-received', [TwilioSmsController::class, 'messageReceived'])
    ->middleware(['is-twilio-request'])
    ->name('api.twilio.message-received');
