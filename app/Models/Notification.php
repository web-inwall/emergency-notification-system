<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_name',
        'message',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'notification__users', 'notification_id', 'user_id');
    }
}
