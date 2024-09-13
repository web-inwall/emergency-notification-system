<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsToMany(User::class, 'notification_recipients');
    }

    public function selectTemplate()
    {
        return 'Выбор шаблона';
        redirect()->back();
    }

    public function sendNotification()
    {
        return 'Отправка нотификации';
        redirect()->back();
    }
}
