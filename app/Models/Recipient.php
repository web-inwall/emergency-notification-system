<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    use HasFactory;

    protected $table = 'recipients'; // Указываем таблицу 'users' для модели Users

    protected $fillable = [
        'bio',
        'link',
        'address',
        'batch_id',
    ];

    public function notification()
    {
        return $this->belongsToMany(Notification::class, 'notification__recipients');
    }
}
