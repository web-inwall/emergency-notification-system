<?php

namespace App\Models\Communications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwilioSmsLog extends Model
{
    use HasFactory;

    protected $table = 'twilio_sms_log';

    protected $guarded = [];
}
