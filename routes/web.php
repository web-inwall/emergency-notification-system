<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\NotificationController;

Route::get('/', [MainController::class, 'index'])->name('main.index');
Route::match(['get', 'post'], '/upload-file', [FileUploadController::class, 'uploadFile'])->name('uploadFile');

Route::get('/users', [UserController::class, 'getUsers'])->name('users.index');

Route::get('/select-template', [NotificationController::class, 'selectTemplate'])->name('selectTemplate');
Route::post('/send-notification', [NotificationController::class, 'sendNotification'])->name('sendNotification');
