<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification_Recipient extends Model
{
    use HasFactory;

    protected $table = 'notification__recipients';

    protected $fillable = [
        'notification_id',
        'recipient_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Recipient::class);
    }

    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}
