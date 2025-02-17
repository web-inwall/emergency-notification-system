<?php

namespace App\Models\Communications;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GmailLog extends Model
{
    use HasFactory;

    protected $table = 'gmail_log';

    protected $guarded = [];
}
