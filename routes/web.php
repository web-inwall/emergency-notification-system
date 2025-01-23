<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\EmailController;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::delete('/delete', [HomeController::class, 'delete'])->name('home.delete');

Route::post('/send-form', [MainController::class, 'manageUserNotificationWorkflow'])->name('main.manageUserNotificationWorkflow');

Route::get('/send-email', [EmailController::class, 'sendEmail']);