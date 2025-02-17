<?php

namespace App\Models\Communications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TelegramLog extends Model
{
    use HasFactory;

    protected $table = 'telegram_log';

    protected $guarded = [];
}
