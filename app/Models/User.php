<?php

namespace App\Models;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'bio',
        'link',
        'address',
    ];

    public function notification()
    {
        return $this->belongsToMany(Notification::class, 'notification_recipients');
    }
}