<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'template_name',
        'message',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'notification__users');
    }
}