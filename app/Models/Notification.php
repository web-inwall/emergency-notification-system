<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'template_name',
        'message',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Recipient::class, 'notification__recipients', 'notification_id', 'wnt_id');
    }
}
