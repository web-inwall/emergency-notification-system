<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TwilioSms extends Model
{
    use HasFactory;

    protected $table = 'twilio_sms';

    protected $guarded = [];
}
