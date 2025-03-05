<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipient extends Model
{
    use HasFactory;

    protected $table = 'recipients';

    protected $fillable = [
        'bio',
        'link',
        'address',
        'batch_id',
    ];

    public function notification(): BelongsToMany
    {
        return $this->belongsToMany(Notification::class, 'notification__recipients');
    }
}
