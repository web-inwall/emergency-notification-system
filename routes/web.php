<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MessageAndFileUploadController;

Route::get('/', [MainController::class, 'index'])->name('main.index');

Route::delete('/delete', [MainController::class, 'delete'])->name('main.delete');

Route::post('/send-form', [MessageAndFileUploadController::class, 'importUsersAndNotify'])->name('importUsersAndNotify');
