<?php

namespace App\Models;

use App\Models\Recipient;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification_Recipient extends Model
{
    use HasFactory;

    protected $table = 'notification__recipients';

    protected $fillable = [
        'notification_id',
        'recipient_id',
    ];

    public function user()
    {
        return $this->belongsTo(Recipient::class);
    }

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
