<?php

namespace App\Repositories\Communications;

use App\Interfaces\GmailRepositoryInterface;
use App\Models\Communications\GmailLog;

class GmailRepository implements GmailRepositoryInterface
{
    public function createLogData($recipient, $status)
    {
        GmailLog::create([
            'email' => $recipient,
            'status' => $status,
        ]);
    }
}
