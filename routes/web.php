<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MessageAndFileUploadController;
// use App\Http\Controllers\NotificationController;

Route::get('/', [MainController::class, 'index'])->name('main.index');

Route::post('/send-form', [MessageAndFileUploadController::class, 'importUsersAndNotify'])->name('importUsersAndNotify');

// Route::get('/select-template', [NotificationController::class, 'selectTemplate'])->name('selectTemplate');
// Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('sendNotification');