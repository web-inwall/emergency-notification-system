<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::delete('/delete', [HomeController::class, 'delete'])->name('home.delete');

Route::post('/send-form', [MainController::class, 'manageUserNotificationWorkflow'])->name('main.manageUserNotificationWorkflow');

Route::get('/test', function () {
    return view('test');
});
